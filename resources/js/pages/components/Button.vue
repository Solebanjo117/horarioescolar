<template>
  <button
    :type="type"
    :disabled="disabled || loading"
    :class="buttonClasses"
    @click="handleClick"
    class="inline-flex items-center justify-center font-medium rounded-lg transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-900 disabled:opacity-50 disabled:cursor-not-allowed"
  >
    <!-- Loading Spinner -->
    <svg
      v-if="loading"
      class="animate-spin -ml-1 mr-2 h-4 w-4"
      xmlns="http://www.w3.org/2000/svg"
      fill="none"
      viewBox="0 0 24 24"
    >
      <circle
        class="opacity-25"
        cx="12"
        cy="12"
        r="10"
        stroke="currentColor"
        stroke-width="4"
      ></circle>
      <path
        class="opacity-75"
        fill="currentColor"
        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
      ></path>
    </svg>

    <!-- Icon (opcional) -->
    <component
      v-if="icon && !loading"
      :is="icon"
      :class="iconClasses"
    />

    <!-- Texto del botón -->
    <span v-if="!loading || showTextWhileLoading">
      <slot>{{ text }}</slot>
    </span>
    <span v-else-if="loading && loadingText">
      {{ loadingText }}
    </span>
  </button>
</template>

<script setup>
import { computed, useSlots } from 'vue'

// Props
const props = defineProps({
  // Variantes del botón
  variant: {
    type: String,
    default: 'primary',
    validator: (value) => ['primary', 'secondary', 'success', 'danger', 'warning', 'ghost', 'outline'].includes(value)
  },
  // Tamaños
  size: {
    type: String,
    default: 'md',
    validator: (value) => ['xs', 'sm', 'md', 'lg', 'xl'].includes(value)
  },
  // Tipo de botón
  type: {
    type: String,
    default: 'button'
  },
  // Estado deshabilitado
  disabled: {
    type: Boolean,
    default: false
  },
  // Estado de carga
  loading: {
    type: Boolean,
    default: false
  },
  // Texto del botón
  text: {
    type: String,
    default: ''
  },
  // Texto mientras carga
  loadingText: {
    type: String,
    default: 'Cargando...'
  },
  // Mostrar texto mientras carga
  showTextWhileLoading: {
    type: Boolean,
    default: false
  },
  // Icono (componente)
  icon: {
    type: [String, Object],
    default: null
  },
  // Posición del icono
  iconPosition: {
    type: String,
    default: 'left',
    validator: (value) => ['left', 'right'].includes(value)
  },
  // Ancho completo
  fullWidth: {
    type: Boolean,
    default: false
  },
  // Bordes redondeados
  rounded: {
    type: String,
    default: 'lg',
    validator: (value) => ['none', 'sm', 'md', 'lg', 'xl', 'full'].includes(value)
  }
})

// Emits
const emit = defineEmits(['click'])

// Slots
const slots = useSlots()

// Computed properties
const buttonClasses = computed(() => {
  return [
    variantClasses.value,
    sizeClasses.value,
    props.fullWidth ? 'w-full' : '',
    `rounded-${props.rounded}`,
  ].filter(Boolean).join(' ')
})

const variantClasses = computed(() => {
  const variants = {
    primary: 'bg-blue-600 hover:bg-blue-700 text-white border border-blue-600 hover:border-blue-700 focus:ring-blue-500 shadow-lg hover:shadow-xl',
    secondary: 'bg-gray-700 hover:bg-gray-600 text-white border border-gray-600 hover:border-gray-500 focus:ring-gray-500 shadow-md hover:shadow-lg',
    success: 'bg-green-600 hover:bg-green-700 text-white border border-green-600 hover:border-green-700 focus:ring-green-500 shadow-lg hover:shadow-xl',
    danger: 'bg-red-600 hover:bg-red-700 text-white border border-red-600 hover:border-red-700 focus:ring-red-500 shadow-lg hover:shadow-xl',
    warning: 'bg-yellow-600 hover:bg-yellow-700 text-white border border-yellow-600 hover:border-yellow-700 focus:ring-yellow-500 shadow-lg hover:shadow-xl',
    ghost: 'bg-transparent hover:bg-gray-800 text-gray-300 hover:text-white border border-transparent focus:ring-gray-500',
    outline: 'bg-transparent hover:bg-gray-800 text-gray-300 hover:text-white border border-gray-600 hover:border-gray-500 focus:ring-gray-500'
  }
  return variants[props.variant] || variants.primary
})

const sizeClasses = computed(() => {
  const sizes = {
    xs: 'px-2 py-1 text-xs',
    sm: 'px-3 py-1.5 text-sm',
    md: 'px-4 py-2 text-sm',
    lg: 'px-6 py-3 text-base',
    xl: 'px-8 py-4 text-lg'
  }
  return sizes[props.size] || sizes.md
})

const iconClasses = computed(() => {
  const baseClasses = 'flex-shrink-0'
  const sizeClasses = {
    xs: 'h-3 w-3',
    sm: 'h-4 w-4',
    md: 'h-4 w-4',
    lg: 'h-5 w-5',
    xl: 'h-6 w-6'
  }
  
  const positionClasses = props.iconPosition === 'right' 
    ? (slots.default || props.text) ? 'ml-2' : ''
    : (slots.default || props.text) ? 'mr-2' : ''

  return `${baseClasses} ${sizeClasses[props.size]} ${positionClasses}`
})

// Methods
const handleClick = (event) => {
  if (!props.disabled && !props.loading) {
    emit('click', event)
  }
}
</script>