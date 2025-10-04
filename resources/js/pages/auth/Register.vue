<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import TextLink from '@/components/TextLink.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AuthBase from '@/layouts/AuthLayout.vue';
import GuestLayout from '@/layouts/GuestLayout.vue';
import { Form, Head } from '@inertiajs/vue3';
import { LoaderCircle } from 'lucide-vue-next';

defineOptions({
  layout: GuestLayout,
});
</script>

<template>
  <AuthBase
    :title="$t('auth.register.title')"
    :description="$t('auth.register.description')"
  >
    <Head :title="$t('auth.register.head_title')" />

    <Form
      method="post"
      :action="route('register')"
      :reset-on-success="['password', 'password_confirmation']"
      v-slot="{ errors, processing }"
      class="flex flex-col gap-6"
      dusk="register-form"
    >
      <div class="grid gap-6">
        <div class="grid gap-2">
          <Label for="name">{{ $t('auth.register.name_label') }}</Label>
          <Input
            id="name"
            type="text"
            required
            autofocus
            :tabindex="1"
            autocomplete="name"
            name="name"
            :placeholder="$t('auth.register.full_name_placeholder')"
            dusk="name"
          />
          <InputError :message="errors.name" />
        </div>

        <div class="grid gap-2">
          <Label for="email">{{ $t('auth.register.email_label') }}</Label>
          <Input
            id="email"
            type="email"
            required
            :tabindex="2"
            autocomplete="email"
            name="email"
            :placeholder="$t('auth.register.email_placeholder')"
            dusk="email"
          />
          <InputError :message="errors.email" />
        </div>

        <div class="grid gap-2">
          <Label for="password">{{ $t('auth.register.password_label') }}</Label>
          <Input
            id="password"
            type="password"
            required
            :tabindex="3"
            autocomplete="new-password"
            name="password"
            :placeholder="$t('auth.register.password_placeholder')"
            dusk="password"
          />
          <InputError :message="errors.password" />
        </div>

        <div class="grid gap-2">
          <Label for="password_confirmation">{{ $t('auth.register.password_confirmation_label') }}</Label>
          <Input
            id="password_confirmation"
            type="password"
            required
            :tabindex="4"
            autocomplete="new-password"
            name="password_confirmation"
            :placeholder="$t('auth.register.password_confirmation_placeholder')"
            dusk="password_confirmation"
          />
          <InputError :message="errors.password_confirmation" />
        </div>

        <Button
          type="submit"
          class="mt-2 w-full"
          :tabindex="5"
          :disabled="processing"
          dusk="submit"
        >
          <LoaderCircle
            v-if="processing"
            class="h-4 w-4 animate-spin"
          />
          {{ $t('auth.register.submit') }}
        </Button>
      </div>

      <div class="text-center text-sm text-muted-foreground">
        {{ $t('auth.register.login_prompt') }}
        <TextLink
          :href="route('login')"
          class="underline underline-offset-4"
          :tabindex="6"
          >{{ $t('auth.register.login_link') }}</TextLink
        >
      </div>
    </Form>
  </AuthBase>
</template>
