<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import TextLink from '@/components/TextLink.vue';
import { Button } from '@/components/ui/button';
import { Checkbox } from '@/components/ui/checkbox';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AuthBase from '@/layouts/AuthLayout.vue';
import GuestLayout from '@/layouts/GuestLayout.vue';
import { Form, Head } from '@inertiajs/vue3';
import { LoaderCircle } from 'lucide-vue-next';

defineProps<{
  status?: string;
  canResetPassword: boolean;
}>();

defineOptions({
  layout: GuestLayout,
});
</script>

<template>
  <AuthBase
    :title="$t('auth.login.title')"
    :description="$t('auth.login.description')"
  >
    <Head :title="$t('auth.login.head_title')" />

    <div
      v-if="status"
      class="mb-4 text-center text-sm font-medium text-green-600"
      dusk="login-status-message"
    >
      {{ status }}
    </div>

    <Form
      method="post"
      :action="route('login')"
      :reset-on-success="['password']"
      v-slot="{ errors, processing }"
      class="flex flex-col gap-6"
      dusk="login-form"
    >
      <div class="grid gap-6">
        <div class="grid gap-2">
          <Label
            for="email"
            dusk="email-label"
            >{{ $t('auth.login.email_label') }}</Label
          >
          <Input
            id="email"
            type="email"
            name="email"
            required
            autofocus
            :tabindex="1"
            autocomplete="email"
            :placeholder="$t('auth.login.email_placeholder')"
            dusk="email-input"
          />
          <InputError
            :message="errors.email"
            dusk="email-error"
          />
        </div>

        <div class="grid gap-2">
          <div class="flex items-center justify-between">
            <Label
              for="password"
              dusk="password-label"
              >{{ $t('auth.login.password_label') }}</Label
            >
            <TextLink
              v-if="canResetPassword"
              :href="route('password.request')"
              class="text-sm"
              :tabindex="5"
              dusk="forgot-password-link"
            >
              {{ $t('auth.login.forgot_password_link') }}
            </TextLink>
          </div>
          <Input
            id="password"
            type="password"
            name="password"
            required
            :tabindex="2"
            autocomplete="current-password"
            :placeholder="$t('auth.login.password_placeholder')"
            dusk="password-input"
          />
          <InputError
            :message="errors.password"
            dusk="password-error"
          />
        </div>

        <div class="flex items-center justify-between">
          <Label
            for="remember"
            class="flex items-center space-x-3"
            dusk="remember-label"
          >
            <Checkbox
              id="remember"
              name="remember"
              :tabindex="3"
              dusk="remember-checkbox"
            />
            <span>{{ $t('auth.login.remember_me') }}</span>
          </Label>
        </div>

        <Button
          type="submit"
          class="mt-4 w-full"
          :tabindex="4"
          :disabled="processing"
          dusk="login-submit-button"
        >
          <LoaderCircle
            v-if="processing"
            class="h-4 w-4 animate-spin"
            dusk="login-spinner"
          />
          {{ $t('auth.login.submit') }}
        </Button>
      </div>

      <div
        class="text-center text-sm text-muted-foreground"
        dusk="register-prompt"
      >
        {{ $t('auth.login.register_prompt') }}
        <TextLink
          :href="route('register')"
          :tabindex="5"
          dusk="register-link"
          >{{ $t('auth.login.register_link') }}</TextLink
        >
      </div>
    </Form>
  </AuthBase>
</template>
