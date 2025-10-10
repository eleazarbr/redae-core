<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import TextLink from '@/components/TextLink.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { useRecaptcha, type RecaptchaConfig } from '@/composables/useRecaptcha';
import AuthBase from '@/layouts/AuthLayout.vue';
import GuestLayout from '@/layouts/GuestLayout.vue';
import { Form, Head } from '@inertiajs/vue3';
import { LoaderCircle } from 'lucide-vue-next';
import { toRef } from 'vue';

defineOptions({
  layout: GuestLayout,
});

const props = defineProps<{
  recaptcha: RecaptchaConfig;
}>();

const { recaptchaToken, shouldDisableSubmit, isRecaptchaEnabled, handleRequestFinished } = useRecaptcha(toRef(props, 'recaptcha'));
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
      :on-finish="handleRequestFinished"
      dusk="register-form"
    >
      <input
        v-if="isRecaptchaEnabled"
        type="hidden"
        name="g-recaptcha-response"
        :value="recaptchaToken"
      />

      <div class="grid gap-6">
        <div class="grid gap-2">
          <Label for="company_name">{{ $t('auth.register.company_name_label') }}</Label>
          <Input
            id="company_name"
            type="text"
            required
            :tabindex="1"
            autocomplete="organization"
            name="company_name"
            :placeholder="$t('auth.register.company_name_placeholder')"
            dusk="company_name"
          />
          <InputError :message="errors.company_name" />
        </div>

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

        <div class="grid gap-2">
          <div class="flex items-center gap-2">
            <input
              id="terms_accepted"
              type="checkbox"
              required
              :tabindex="5"
              name="terms_accepted"
              class="mt-1 h-4 w-4 rounded border border-input bg-background ring-offset-background focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 focus-visible:outline-none"
              dusk="terms_accepted"
            />
            <Label
              for="terms_accepted"
              class="text-sm leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70"
            >
              <span
                class="leading-relaxed"
                v-html="
                  $t('auth.register.terms_and_privacy_label', {
                    terms_link: `<a href='${route('terms')}' target='_blank' class='underline underline-offset-4'>${$t('auth.register.terms_link')}</a>`,
                    privacy_link: `<a href='${route('privacy')}' target='_blank' class='underline underline-offset-4'>${$t('auth.register.privacy_link')}</a>`,
                  })
                "
              ></span>
            </Label>
          </div>
          <InputError :message="errors.terms_accepted" />
        </div>

        <Button
          type="submit"
          class="mt-2 w-full"
          :tabindex="6"
          :disabled="processing || shouldDisableSubmit"
          dusk="submit"
        >
          <LoaderCircle
            v-if="processing"
            class="h-4 w-4 animate-spin"
          />
          {{ $t('auth.register.submit') }}
        </Button>

        <InputError :message="errors['g-recaptcha-response']" />
      </div>

      <div class="text-center text-sm text-muted-foreground">
        {{ $t('auth.register.login_prompt') }}
        <TextLink
          :href="route('login')"
          class="underline underline-offset-4"
          :tabindex="7"
          >{{ $t('auth.register.login_link') }}
        </TextLink>
      </div>
    </Form>
  </AuthBase>
</template>
