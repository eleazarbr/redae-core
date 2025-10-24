import '../css/app.css';

import { createInertiaApp } from '@inertiajs/vue3';
import { i18nVue } from 'laravel-vue-i18n';
import { createApp, h } from 'vue';
import { ZiggyVue } from 'ziggy-js';
import { initializeTheme } from './composables/useAppearance';
import { formatTitle } from './lib/utils';
import { resolveInertia } from './registry';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
  title: (title) => formatTitle(title, appName),
  resolve: (name) => resolveInertia(name),
  setup({ el, App, props, plugin }) {
    createApp({ render: () => h(App, props) })
      .provide('appName', appName)
      .use(plugin)
      .use(ZiggyVue)
      .use(i18nVue, { resolve: (lang: string) => import(`../../lang/php_${lang}.json`) })
      .mount(el);
  },
  progress: {
    color: '#4B5563',
  },
});

// This will set light / dark mode on page load...
initializeTheme();
