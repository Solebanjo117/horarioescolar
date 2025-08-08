<template>
  <Teleport to="body">
    <Transition
      name="modal"
      enter-active-class="transition duration-300 ease-out"
      enter-from-class="opacity-0"
      enter-to-class="opacity-100"
      leave-active-class="transition duration-200 ease-in"
      leave-from-class="opacity-100"
      leave-to-class="opacity-0"
    >
      <div
        v-if="modelValue"
        class="fixed inset-0 z-50 flex items-center justify-center overflow-x-hidden overflow-y-auto"
        @click="handleBackdropClick"
      >
        <!-- Backdrop -->
        <div class="fixed inset-0 bg-black bg-opacity-75 backdrop-blur-sm"></div>
        
        <!-- Modal Container -->
        <div
          class="relative w-full max-w-lg mx-4 transform transition-all duration-300"
          :class="[
            modelValue ? 'scale-100 translate-y-0' : 'scale-95 translate-y-4',
            sizeClasses
          ]"
        >
          <!-- Modal Content -->
          <div class="relative bg-gray-800 rounded-xl shadow-2xl border border-gray-700 overflow-hidden">
            
            <!-- Header -->
            <div 
              v-if="showHeader"
              class="flex items-center justify-between px-6 py-4 border-b border-gray-700"
            >
              <div class="flex items-center space-x-3">
                <!-- Icon -->
                <component
                  v-if="icon"
                  :is="icon"
                  :class="iconClasses"
                />
                
                <!-- Title -->
                <div>
                  <h3 v-if="title" class="text-lg font-semibold text-white">
                    {{ title }}
                  </h3>
                  <p v-if="subtitle" class="text-sm text-gray-400 mt-1">
                    {{ subtitle }}
                  </p>
                </div>
              </div>
              
              <!-- Close Button -->
              <button
                v-if="showCloseButton"
                @click="closeModal"
                class="p-2 text-gray-400 hover:text-white hover:bg-gray-700 rounded-lg transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-gray-500"
                :disabled="loading"
              >
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
              </button>
            </div>
            
            <!-- Body -->
            <div :class="bodyClasses">
              <slot>
                <p v-if="message" class="text-gray-300">{{ message }}</p>
              </slot>
            </div>
            
            <!-- Footer -->
            <div 
              v-if="showFooter"
              class="flex items-center justify-end space-x-3 px-6 py-4 border-t border-gray-700 bg-gray-750"
            >
              <slot name="footer">
                <!-- Cancel Button -->
                <button
                  v-if="showCancelButton"
                  @click="handleCancel"
                  :disabled="loading"
                  class="px-4 py-2 text-sm font-medium text-gray-300 bg-transparent hover:bg-gray-700 border border-gray-600 hover:border-gray-500 rounded-lg transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-gray-500 disabled:opacity-50"
                >
                  {{ cancelText }}
                </button>
                
                <!-- Confirm Button -->
                <button
                  v-if="showConfirmButton"
                  @click="handleConfirm"
                  :disabled="loading"
                  :class="confirmButtonClasses"
                  class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-lg transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 disabled:opacity-50"
                >
                  <!-- Loading Spinner -->
                  <svg
                    v-if="loading"
                    class="animate-spin -ml-1 mr-2 h-4 w-4"
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                  >
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                  </svg>
                  
                  {{ loading ? loadingText : confirmText }}
                </button>
              </slot>
            </div>
          </div>
        </div>
      </div>
    </Transition>
  </Teleport>
</template>

<script setup>
import { computed, watch, nextTick } from 'vue'

// Props
const props = defineProps({
  // Control del modal
  modelValue: {
    type: Boolean,
    default: false
  },
  
  // Contenido
  title: {
    type: String,
    default: ''
  },
  
  subtitle: {
    type: String,
    default: ''
  },
  
  message: {
    type: String,
    default: ''
  },
  
  // Tamaños
  size: {
    type: String,
    default: 'md',
    validator: (value) => ['xs', 'sm', 'md', 'lg', 'xl', 'full'].includes(value)
  },
  
  // Variantes de confirmación
  variant: {
    type: String,
    default: 'primary',
    validator: (value) => ['primary', 'success', 'warning', 'danger'].includes(value)
  },
  
  // Estados
  loading: {
    type: Boolean,
    default: false
  },
  
  // Configuración de botones
  showHeader: {
    type: Boolean,
    default: true
  },
  
  showFooter: {
    type: Boolean,
    default: true
  },
  
  showCloseButton: {
    type: Boolean,
    default: true
  },
  
  showCancelButton: {
    type: Boolean,
    default: true
  },
  
  showConfirmButton: {
    type: Boolean,
    default: true
  },
  
  // Textos de botones
  cancelText: {
    type: String,
    default: 'Cancelar'
  },
  
  confirmText: {
    type: String,
    default: 'Confirmar'
  },
  
  loadingText: {
    type: String,
    default: 'Procesando...'
  },
  
  // Comportamiento
  persistent: {
    type: Boolean,
    default: false
  },
  
  closeOnBackdrop: {
    type: Boolean,
    default: true
  },
  
  closeOnEscape: {
    type: Boolean,
    default: true
  },
  
  // Icono
  icon: {
    type: [String, Object],
    default: null
  },
  
  // Padding personalizado del body
  bodyPadding: {
    type: String,
    default: 'px-6 py-4'
  }
})

// Emits
const emit = defineEmits([
  'update:modelValue',
  'close',
  'cancel',
  'confirm',
  'opened',
  'closed'
])

// Computed Properties
const sizeClasses = computed(() => {
  const sizes = {
    xs: 'max-w-xs',
    sm: 'max-w-sm',
    md: 'max-w-md',
    lg: 'max-w-lg',
    xl: 'max-w-xl',
    full: 'max-w-full mx-4'
  }
  return sizes[props.size] || sizes.md
})

const bodyClasses = computed(() => {
  return props.bodyPadding
})

const iconClasses = computed(() => {
  const variants = {
    primary: 'text-blue-500',
    success: 'text-green-500',
    warning: 'text-yellow-500',
    danger: 'text-red-500'
  }
  return `w-6 h-6 ${variants[props.variant] || variants.primary}`
})

const confirmButtonClasses = computed(() => {
  const variants = {
    primary: 'bg-blue-600 hover:bg-blue-700 text-white focus:ring-blue-500',
    success: 'bg-green-600 hover:bg-green-700 text-white focus:ring-green-500',
    warning: 'bg-yellow-600 hover:bg-yellow-700 text-white focus:ring-yellow-500',
    danger: 'bg-red-600 hover:bg-red-700 text-white focus:ring-red-500'
  }
  return variants[props.variant] || variants.primary
})

// Methods
const closeModal = () => {
  if (!props.persistent && !props.loading) {
    emit('update:modelValue', false)
    emit('close')
  }
}

const handleBackdropClick = (event) => {
  if (event.target === event.currentTarget && props.closeOnBackdrop) {
    closeModal()
  }
}

const handleCancel = () => {
  if (!props.loading) {
    emit('cancel')
    closeModal()
  }
}

const handleConfirm = () => {
  if (!props.loading) {
    emit('confirm')
  }
}

const handleEscape = (event) => {
  if (event.key === 'Escape' && props.closeOnEscape && props.modelValue) {
    closeModal()
  }
}

// Watchers
watch(() => props.modelValue, (newValue) => {
  if (newValue) {
    document.addEventListener('keydown', handleEscape)
    document.body.style.overflow = 'hidden'
    nextTick(() => emit('opened'))
  } else {
    document.removeEventListener('keydown', handleEscape)
    document.body.style.overflow = ''
    nextTick(() => emit('closed'))
  }
})

// Cleanup on unmount
import { onBeforeUnmount } from 'vue'
onBeforeUnmount(() => {
  document.removeEventListener('keydown', handleEscape)
  document.body.style.overflow = ''
})
</script>

<style scoped>
.modal-enter-active .modal-container {
  transition: all 0.3s ease-out;
}

.modal-leave-active .modal-container {
  transition: all 0.2s ease-in;
}

.modal-enter-from .modal-container,
.modal-leave-to .modal-container {
  transform: scale(0.95) translateY(16px);
}

/* Para el backdrop blur en navegadores que lo soporten */
@supports (backdrop-filter: blur(4px)) {
  .backdrop-blur-sm {
    backdrop-filter: blur(4px);
  }
}
</style>