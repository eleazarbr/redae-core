import { computed, onBeforeUnmount, onMounted, ref, unref, type MaybeRef } from 'vue';

export interface RecaptchaConfig {
    enabled: boolean;
    siteKey: string | null;
    scriptUrl: string | null;
    action: string;
}

declare global {
    interface Window {
        grecaptcha?: {
            ready(callback: () => void): void;
            execute(siteKey: string, options: { action: string }): Promise<string>;
        };
    }
}

const isClient = typeof window !== 'undefined' && typeof document !== 'undefined';
const SCRIPT_ID = 'google-recaptcha-script';

const buildScriptSource = (config: RecaptchaConfig | null) => {
    if (!config?.siteKey) {
        return null;
    }

    const baseUrl = config.scriptUrl ?? 'https://www.google.com/recaptcha/api.js';
    const separator = baseUrl.includes('?') ? '&' : '?';

    return `${baseUrl}${separator}render=${config.siteKey}`;
};

export const useRecaptcha = (configInput: MaybeRef<RecaptchaConfig | null | undefined>) => {
    const recaptchaToken = ref('');
    let refreshInterval: number | undefined;

    const config = computed(() => unref(configInput) ?? null);
    const isRecaptchaEnabled = computed(() => Boolean(config.value?.enabled && config.value.siteKey));
    const shouldDisableSubmit = computed(() => isRecaptchaEnabled.value && !recaptchaToken.value);

    const executeRecaptcha = async () => {
        const currentConfig = config.value;

        if (!isClient || !currentConfig?.siteKey || !window.grecaptcha) {
            recaptchaToken.value = '';
            return;
        }

        try {
            recaptchaToken.value = await window.grecaptcha.execute(currentConfig.siteKey, {
                action: currentConfig.action,
            });
        } catch (error) {
            console.error('Failed to execute Google reCAPTCHA', error);
            recaptchaToken.value = '';
        }
    };

    const scheduleRefresh = () => {
        if (!isClient) {
            return;
        }

        if (refreshInterval) {
            window.clearInterval(refreshInterval);
        }

        refreshInterval = window.setInterval(() => {
            void executeRecaptcha();
        }, 110_000);
    };

    const initializeRecaptcha = () => {
        if (!isClient || !window.grecaptcha) {
            return;
        }

        window.grecaptcha.ready(async () => {
            await executeRecaptcha();
            scheduleRefresh();
        });
    };

    const loadRecaptchaScript = () => {
        if (!isClient) {
            return;
        }

        const scriptSrc = buildScriptSource(config.value);
        if (!scriptSrc) {
            return;
        }

        const existingScript = document.getElementById(SCRIPT_ID) as HTMLScriptElement | null;

        if (existingScript) {
            if (window.grecaptcha) {
                initializeRecaptcha();
            } else {
                existingScript.addEventListener('load', initializeRecaptcha, { once: true });
            }

            return;
        }

        const script = document.createElement('script');
        script.id = SCRIPT_ID;
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
        if (!isRecaptchaEnabled.value) {
            return;
        }

        void executeRecaptcha();
    };

    onMounted(() => {
        if (!isRecaptchaEnabled.value || !config.value?.siteKey) {
            return;
        }

        loadRecaptchaScript();
    });

    onBeforeUnmount(() => {
        if (!isClient) {
            return;
        }

        if (refreshInterval) {
            window.clearInterval(refreshInterval);
            refreshInterval = undefined;
        }
    });

    return {
        recaptchaToken,
        isRecaptchaEnabled,
        shouldDisableSubmit,
        handleRequestFinished,
    };
};
