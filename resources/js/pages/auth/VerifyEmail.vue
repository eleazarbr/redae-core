<script setup lang="ts">
import TextLink from '@/components/TextLink.vue';
import { Button } from '@/components/ui/button';
import AuthLayout from '@/layouts/AuthLayout.vue';
import { Form, Head } from '@inertiajs/vue3';
import { LoaderCircle } from 'lucide-vue-next';

defineProps<{
  status?: string;
}>();
</script>

<template>
  <AuthLayout
    :title="$t('auth.verify_email.title')"
    :description="$t('auth.verify_email.description')"
  >
    <Head :title="$t('auth.verify_email.title')" />

    <div
      v-if="status === 'verification-link-sent'"
      class="mb-4 text-center text-sm font-medium text-green-600"
    >
      {{ $t('auth.verify_email.link_sent') }}
    </div>

    <Form
      method="post"
      :action="route('verification.send')"
      class="space-y-6 text-center"
      v-slot="{ processing }"
    >
      <Button
        :disabled="processing"
        variant="secondary"
      >
        <LoaderCircle
          v-if="processing"
          class="h-4 w-4 animate-spin"
        />
        {{ $t('auth.verify_email.submit') }}
      </Button>

      <TextLink
        :href="route('logout')"
        method="post"
        as="button"
        class="mx-auto block text-sm"
      >
        {{ $t('auth.verify_email.logout') }}
      </TextLink>
    </Form>
  </AuthLayout>
</template>
