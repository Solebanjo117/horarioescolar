<script setup lang="ts">

import AppLayout from '@/layouts/AppLayout.vue';
import { Head,router } from '@inertiajs/vue3';
import Form from '@/pages/puestos/Form.vue';
import Button from '@/pages/components/Button.vue';
import { type BreadcrumbItem,type Puesto,type Pagination } from '@/types';
import PaginationLinks from '../components/PaginationLinks.vue';
import AutoTable from '@/pages/components/AutoTable.vue';
import { defineProps,computed } from 'vue';
const props = defineProps<{
  puestos: Pagination<Puesto>;
  puesto?: Puesto;
  modo?: string; //create-edit
}>();
const breadcrumbs = computed(() => {
   let items = [
        {
            title: 'Puestos',
            href: '/puestos',
        },
    ]
     if (props.modo === 'create') {
    items.push({ title: 'Crear puesto', href: '/puestos/create' });
  } else if (props.modo === 'edit' && props.puesto) {
    items.push({ title: `Editar puesto ${props.puesto.nombre} #${props.puesto.id}`, href: '#' });
  }
   return items;
});
const columnas = [
  { key: 'id', label: 'ID' },
  { key: 'nombre', label: 'Nombre' },
  { key: 'tipo', label: 'Tipo' },
];


</script>
<template>
  <AppLayout :breadcrumbs="breadcrumbs">
    <Head title="Puestos"></Head>
    <div>
    <h1>Puestos</h1>
  </div>
  <div class="flex justify-center mb-5">
    <Button class="w-50" variant="secondary"  size="lg"
     @click="router.get('/puestos/create', {}, { preserveScroll: false, preserveState: false })">Nuevo puesto</Button>
  </div>
  <Form v-if="modo === 'create' || modo === 'edit'" :puesto="puesto" :modo="modo"></Form>
  <AutoTable class="m-4" :data="puestos.data" :columns="columnas" route="puestos" />
  <PaginationLinks :propiedades="puestos" class="m-4" />
  </AppLayout>
</template>