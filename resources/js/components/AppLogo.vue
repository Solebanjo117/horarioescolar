<script setup lang="ts">
import { CircleUserIcon } from 'lucide-vue-next';
import { usePage } from '@inertiajs/vue3';
import type { User } from '@/types';
const page = usePage();
const user = page.props.auth.user as User;
</script>

<template>
    <div class="flex aspect-square size-8 items-center justify-center rounded-md  text-sidebar-primary-foreground">
        <CircleUserIcon class="size-8 mb-1 text-white dark:text-black" color="#ffffff"/>
    </div>
    <div class="ml-1 grid flex-1 text-left text-sm">
        <span class="mb-0.5 truncate leading-tight font-semibold">Bienvenido {{ user.name }} </span>
    </div>
</template>