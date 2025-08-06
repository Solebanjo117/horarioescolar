<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import PlaceholderPattern from '../components/PlaceholderPattern.vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Inicio',
        href: '/dashboard',
    },
];
</script>

<template>
    <Head title="Inicio" />

    <AppLayout :breadcrumbs="breadcrumbs">
      <div class="justify-center">
        <p>Esta es la pagina principal</p>
        
    </div>
    </AppLayout>
</template>
