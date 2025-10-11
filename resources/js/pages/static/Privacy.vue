<script setup lang="ts">
import GuestLayout from '@/layouts/GuestLayout.vue';
import StaticPageLayout from '@/layouts/static/StaticPageLayout.vue';
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
  <StaticPageLayout
    :title="pageTitle"
    :description="pageDescription"
  >
    <Head :title="pageTitle" />

    <div
      class="content"
      v-html="content"
    />

    <p
      v-if="lastUpdated"
      class="mt-10 text-sm text-muted-foreground"
    >
      {{ $t('static.updated_at', { date: lastUpdated }) }}
    </p>
  </StaticPageLayout>
</template>
