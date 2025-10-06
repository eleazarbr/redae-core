<script setup lang="ts">
import GuestLayout from '@/layouts/GuestLayout.vue';
import AuthBase from '@/layouts/AuthLayout.vue';
import { Head } from '@inertiajs/vue3';

const pageTitle = 'Privacy Policy';
const pageDescription = 'Read the privacy policy for using our application.';

defineOptions({
  layout: GuestLayout,
});

interface Props {
  content: string;
  lastUpdated?: string;
}

defineProps<Props>();
</script>

<template>
  <AuthBase
    :title="pageTitle"
    :description="pageDescription"
  >
    <Head :title="pageTitle" />

    <!-- Content -->
    <div class="flex flex-col gap-6">
      <div class="prose prose-lg dark:prose-invert max-w-none">
        <div v-html="content"></div>
      </div>

      <div
        v-if="lastUpdated"
        class="text-sm text-gray-500 dark:text-gray-400"
      >
        Last updated: {{ lastUpdated }}
      </div>
    </div>
  </AuthBase>
</template>
