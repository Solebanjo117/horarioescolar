<script setup lang="ts">

import { Head,useForm } from '@inertiajs/vue3';
import { defineProps } from 'vue';
import Button from '../components/Button.vue';
    import type { Puesto } from '@/types';

const props = defineProps<{
    puesto?: Puesto; // Optional puesto for edit mode
    modo?: string; // Mode can be 'create' or 'edit'
    }>();
const form = useForm({
  nombre: props.puesto?.nombre || '',
  tipo: props.puesto?.tipo || '',
});
function guardar(){
    if(props.puesto && props.puesto.id !== undefined){
        form.put(route('puestos.update',props.puesto.id)),{
            preserveScroll:true,
            
        };
    }else{
        form.post(route('puestos.store'),{
            preserveScroll:true,
        });
    }
}
</script>
<template>
<Head :title="props.modo === 'edit' ? `Editar puesto ${props.puesto?.nombre}` : 'Crear puesto'"></Head>

    <form @submit.prevent="guardar" class="max-w-md mx-auto bg-gray-800 p-8 rounded-lg shadow-lg border border-gray-700">
 <h2 class="text-center mb-1">{{ props.modo === 'edit' ? `Editar puesto ${props.puesto?.nombre}` : 'Crear puesto' }}</h2>
        <div class="mb-6">
    <label for="nombre" class="block text-sm font-medium text-gray-300 mb-2">
      Nombre
    </label>
    <input 
      id="nombre" 
      v-model="form.nombre" 
      type="text" 
      class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
      placeholder="Ingresa el nombre"
    />
  </div>
  
  <div class="mb-6">
    <label for="tipo" class="block text-sm font-medium text-gray-300 mb-2">
      Tipo
    </label>
    <input 
      id="tipo" 
      v-model="form.tipo" 
      type="text" 
      class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
      placeholder="Ingresa el tipo"
    />
  </div>

 <div class="flex justify-center"> 
  <Button type="submit" :loading="form.processing">Guardar</Button></div>
</form>
</template>