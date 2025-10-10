<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import TextLink from '@/components/TextLink.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { useRecaptcha, type RecaptchaConfig } from '@/composables/useRecaptcha';
import AuthLayout from '@/layouts/AuthLayout.vue';
import { Form, Head } from '@inertiajs/vue3';
import { LoaderCircle } from 'lucide-vue-next';
import { toRef } from 'vue';

const props = defineProps<{
  status?: string;
  recaptcha: RecaptchaConfig;
}>();

const { recaptchaToken, shouldDisableSubmit, isRecaptchaEnabled, handleRequestFinished } = useRecaptcha(toRef(props, 'recaptcha'));
</script>

<template>
  <AuthLayout
    :title="$t('auth.forgot_password.title')"
    :description="$t('auth.forgot_password.description')"
  >
    <Head :title="$t('auth.forgot_password.head_title')" />

    <div
      v-if="props.status"
      class="mb-4 text-center text-sm font-medium text-green-600"
      dusk="forgot-password-status-message"
    >
      {{ props.status }}
    </div>

    <div
      class="space-y-6"
      dusk="forgot-password-container"
    >
      <Form
        method="post"
        :action="route('password.email')"
        v-slot="{ errors, processing }"
        dusk="forgot-password-form"
        :on-finish="handleRequestFinished"
      >
        <input
          v-if="isRecaptchaEnabled"
          type="hidden"
          name="g-recaptcha-response"
          :value="recaptchaToken"
        />

        <div class="grid gap-2">
          <Label
            for="email"
            dusk="email-label"
            >{{ $t('auth.forgot_password.email_label') }}</Label
          >
          <Input
            id="email"
            type="email"
            name="email"
            autocomplete="off"
            autofocus
            :placeholder="$t('auth.forgot_password.email_placeholder')"
            dusk="email-input"
          />
          <InputError
            :message="errors.email"
            dusk="email-error"
          />
        </div>

        <div class="my-6 flex items-center justify-start">
          <Button
            class="w-full"
            :disabled="processing || shouldDisableSubmit"
            dusk="forgot-password-submit-button"
          >
            <LoaderCircle
              v-if="processing"
              class="h-4 w-4 animate-spin"
              dusk="forgot-password-spinner"
            />
            {{ $t('auth.forgot_password.submit') }}
          </Button>
        </div>

        <InputError :message="errors['g-recaptcha-response']" />
      </Form>

      <div
        class="space-x-1 text-center text-sm text-muted-foreground"
        dusk="login-prompt"
      >
        <span>{{ $t('auth.forgot_password.login_prompt') }}</span>
        <TextLink
          :href="route('login')"
          dusk="login-link"
          >{{ $t('auth.forgot_password.login_link') }}</TextLink
        >
      </div>
    </div>
  </AuthLayout>
</template>
