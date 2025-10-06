<script setup lang="ts">
import GuestLayout from '@/layouts/GuestLayout.vue';
import { Head } from '@inertiajs/vue3';

const pageTitle = 'Terms of Service';
const pageDescription = 'Read the terms of service for using our application.';

defineOptions({
  layout: GuestLayout,
});
</script>

<template>
  <AuthBase
    :title="pageTitle"
    :description="pageDescription"
  >
    <Head :title="pageTitle" />

    <!-- Content -->
    <div class="flex flex-col gap-6">
      <div class="grid gap-6"></div>
    </div>
  </AuthBase>
</template>
