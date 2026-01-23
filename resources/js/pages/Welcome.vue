<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { inject } from 'vue';
import GuestLayout from '@/layouts/GuestLayout.vue';

const appName = inject<string>('appName', 'App');

defineOptions({
  layout: GuestLayout,
});
</script>

<template>
  <Head :title="appName" />

  <div class="text-4xl font-semibold text-slate-900 dark:text-slate-100">
    {{ appName }}
  </div>
</template>
