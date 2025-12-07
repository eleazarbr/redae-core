import '../css/app.css';

import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { i18nVue } from 'laravel-vue-i18n';
import { createApp, h } from 'vue';
import { ZiggyVue } from 'ziggy-js';
import { initializeTheme } from './composables/useAppearance';
import { formatTitle } from './lib/utils';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';
type PageLoader = () => Promise<unknown>;
type PageRegistry = Record<string, PageLoader>;

const localPages: PageRegistry = import.meta.glob('./pages/**/*.vue');
const vendorPages: PageRegistry = import.meta.glob('../../vendor/**/**/resources/js/pages/**/*.vue');

const buildIndex = (pages: PageRegistry) => {
  const index: Record<string, string> = {};
  Object.keys(pages).forEach((path) => {
    const vendorMatch = path.match(/^\.\.\/\.\.\/vendor\/[^/]+\/([\w-]+)\/resources\/js\/pages\/(.+)\.vue$/i);
    if (vendorMatch) {
      index[`${vendorMatch[1]}/${vendorMatch[2]}`] = path;
      return;
    }

    const localMatch = path.match(/^\.\/pages\/(.+)\.vue$/i);
    if (localMatch) {
      index[localMatch[1]] = path;
    }
  });

  return index;
};

const localIndex = buildIndex(localPages);
const vendorIndex = buildIndex(vendorPages);

createInertiaApp({
  title: (title) => formatTitle(title, appName),
  resolve: (name) => {
    const fallbackName = name.includes('/') ? name.split('/').slice(1).join('/') : null;
    const localPath = localIndex[name];
    if (localPath) {
      return resolvePageComponent(localPath, localPages) as any;
    }

    const vendorPath = vendorIndex[name] ?? (fallbackName ? vendorIndex[fallbackName] : undefined);
    if (vendorPath) {
      return resolvePageComponent(vendorPath, vendorPages) as any;
    }

    throw new Error(`Page not found: ${name}`);
  },
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
