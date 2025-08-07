
<template>
    <div class="mt-4 ml-4 flex gap-2">
<button
  v-for="link in propiedades.links"
  :key="link.label"
  :disabled="!link.url"
  v-html="link.label"
  @click="irAPagina(link.url)"
  :class="[
    'px-3 py-2 border rounded-lg text-sm font-medium transition-all duration-200',
    link.active 
      ? 'bg-blue-600 text-white border-blue-600 shadow-md' 
      : 'bg-gray-800 text-gray-300 border-gray-600 hover:bg-gray-700 hover:text-white hover:border-gray-500',
    !link.url && 'opacity-50 cursor-not-allowed hover:bg-gray-800 hover:text-gray-300 hover:border-gray-600',
  ]"
></button>
</div>
</template>
<script setup lang="ts">
import { defineProps } from 'vue';
import { router } from '@inertiajs/vue3';
import type { Pagination } from '@/types';
const props = defineProps<{
  propiedades: Pagination<any>;
}>();
function irAPagina(url: string | null) {
  if (url) router.visit(url);
}
</script>
