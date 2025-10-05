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
import { onBeforeUnmount, onMounted, ref } from 'vue';

defineOptions({
  layout: GuestLayout,
});

const props = defineProps<{
  recaptcha: {
    enabled: boolean;
    siteKey: string | null;
    scriptUrl: string | null;
    action: string;
  };
}>();

declare global {
  interface Window {
    grecaptcha?: {
      ready(callback: () => void): void;
      execute(siteKey: string, options: { action: string }): Promise<string>;
    };
  }
}

const recaptchaToken = ref('');
let refreshInterval: number | undefined;

const buildScriptSource = () => {
  if (!props.recaptcha.siteKey) {
    return null;
  }

  const baseUrl = props.recaptcha.scriptUrl ?? 'https://www.google.com/recaptcha/api.js';
  const separator = baseUrl.includes('?') ? '&' : '?';

  return `${baseUrl}${separator}render=${props.recaptcha.siteKey}`;
};

const executeRecaptcha = async () => {
  if (!props.recaptcha.siteKey || !window.grecaptcha) {
    return;
  }

  try {
    recaptchaToken.value = await window.grecaptcha.execute(props.recaptcha.siteKey, {
      action: props.recaptcha.action,
    });
  } catch (error) {
    console.error('Failed to execute Google reCAPTCHA', error);
    recaptchaToken.value = '';
  }
};

const scheduleRefresh = () => {
  if (refreshInterval) {
    window.clearInterval(refreshInterval);
  }

  refreshInterval = window.setInterval(() => {
    void executeRecaptcha();
  }, 110_000);
};

const initializeRecaptcha = () => {
  if (!window.grecaptcha) {
    return;
  }

  window.grecaptcha.ready(async () => {
    await executeRecaptcha();
    scheduleRefresh();
  });
};

const loadRecaptchaScript = () => {
  const scriptSrc = buildScriptSource();
  if (!scriptSrc) {
    return;
  }

  const scriptId = 'google-recaptcha-script';
  const existingScript = document.getElementById(scriptId) as HTMLScriptElement | null;

  if (existingScript) {
    if (window.grecaptcha) {
      initializeRecaptcha();
    } else {
      existingScript.addEventListener('load', initializeRecaptcha, { once: true });
    }

    return;
  }

  const script = document.createElement('script');
  script.id = scriptId;
  script.src = scriptSrc;
  script.async = true;
  script.defer = true;
  script.addEventListener('load', initializeRecaptcha, { once: true });
  script.addEventListener('error', (event) => {
    console.error('Failed to load Google reCAPTCHA script', event);
  });

  document.head.appendChild(script);
};

const handleRequestFinished = () => {
  if (!props.recaptcha.enabled) {
    return;
  }

  void executeRecaptcha();
};

onMounted(() => {
  if (props.recaptcha.enabled && props.recaptcha.siteKey) {
    loadRecaptchaScript();
  }
});

onBeforeUnmount(() => {
  if (refreshInterval) {
    window.clearInterval(refreshInterval);
    refreshInterval = undefined;
  }
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
      :on-finish="handleRequestFinished"
      dusk="register-form"
    >
      <input
        v-if="props.recaptcha.enabled"
        type="hidden"
        name="g-recaptcha-response"
        :value="recaptchaToken"
      />

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
          :disabled="processing || (props.recaptcha.enabled && !recaptchaToken)"
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
          :tabindex="6"
          >{{ $t('auth.register.login_link') }}</TextLink
        >
      </div>
    </Form>
  </AuthBase>
</template>
