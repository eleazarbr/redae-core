<template>
  <div :id="props.id"></div>
</template>

<script setup lang="ts">
import { onBeforeUnmount, onMounted, ref } from 'vue';

defineOptions({
  name: 'google-recaptcha-v3',
});

const props = withDefaults(
  defineProps<{
    action?: string;
    id?: string;
    siteKey?: string;
    inline?: boolean;
  }>(),
  {
    action: 'validate_grecaptcha',
    id: 'grecaptcha_container',
    siteKey: '',
    inline: false,
  },
);

const emit = defineEmits<{
  (event: 'input', token: string): void;
}>();

type RecaptchaCallback = () => void;

type GrecaptchaRenderOptions = {
  sitekey: string;
  badge?: string;
  size?: 'invisible' | 'compact' | 'normal';
  'expired-callback'?: () => void;
};

interface Grecaptcha {
  render(container: string | HTMLElement, parameters: GrecaptchaRenderOptions): number;
  execute(widgetId: number, options: { action: string }): Promise<string>;
}

interface RecaptchaWindow extends Window {
  grecaptcha?: Grecaptcha;
  gRecaptchaOnLoadCallbacks?: RecaptchaCallback[];
  gRecaptchaOnLoad?: () => void;
}

const isClient = typeof window !== 'undefined' && typeof document !== 'undefined';
const RECAPTCHA_SCRIPT_ID = 'gRecaptchaScript';

const captchaId = ref<number | null>(null);

const executeCaptcha = () => {
  if (!isClient) {
    return;
  }

  const win = window as RecaptchaWindow;

  if (captchaId.value === null || !win.grecaptcha?.execute) {
    return;
  }

  win.grecaptcha
    .execute(captchaId.value, {
      action: props.action,
    })
    .then((token) => {
      emit('input', token);
    });
};

const renderCaptcha = () => {
  if (!isClient) {
    return;
  }

  const win = window as RecaptchaWindow;

  if (!win.grecaptcha?.render) {
    return;
  }

  captchaId.value = win.grecaptcha.render(props.id, {
    sitekey: props.siteKey,
    badge: props.inline ? 'inline' : '',
    size: 'invisible',
    'expired-callback': executeCaptcha,
  });

  executeCaptcha();
};

const registerOnLoadCallback = () => {
  if (!isClient) {
    return;
  }

  const win = window as RecaptchaWindow;

  if (!win.gRecaptchaOnLoadCallbacks) {
    win.gRecaptchaOnLoadCallbacks = [];
  }

  if (!win.gRecaptchaOnLoadCallbacks.includes(renderCaptcha)) {
    win.gRecaptchaOnLoadCallbacks.push(renderCaptcha);
  }
};

const init = () => {
  if (!isClient) {
    return;
  }

  const win = window as RecaptchaWindow;
  const scriptExists = Boolean(document.getElementById(RECAPTCHA_SCRIPT_ID));

  if (!scriptExists) {
    registerOnLoadCallback();

    if (!win.gRecaptchaOnLoad) {
      win.gRecaptchaOnLoad = () => {
        win.gRecaptchaOnLoadCallbacks?.forEach((callback) => {
          callback();
        });
        delete win.gRecaptchaOnLoadCallbacks;
        delete win.gRecaptchaOnLoad;
      };
    }

    const recaptchaScript = document.createElement('script');
    recaptchaScript.setAttribute('src', 'https://www.google.com/recaptcha/api.js?render=explicit&onload=gRecaptchaOnLoad');
    recaptchaScript.setAttribute('id', RECAPTCHA_SCRIPT_ID);
    recaptchaScript.async = true;
    recaptchaScript.defer = true;
    document.head.appendChild(recaptchaScript);
    return;
  }

  if (!win.grecaptcha || !win.grecaptcha.render) {
    registerOnLoadCallback();
    return;
  }

  renderCaptcha();
};

onMounted(() => {
  init();
});

onBeforeUnmount(() => {
  if (!isClient) {
    return;
  }

  const win = window as RecaptchaWindow;

  if (!win.gRecaptchaOnLoadCallbacks) {
    return;
  }

  win.gRecaptchaOnLoadCallbacks = win.gRecaptchaOnLoadCallbacks.filter((callback) => callback !== renderCaptcha);

  if (win.gRecaptchaOnLoadCallbacks.length === 0) {
    delete win.gRecaptchaOnLoadCallbacks;
  }
});
</script>
