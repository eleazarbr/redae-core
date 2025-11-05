import { createInertiaApp } from '@inertiajs/vue3';
import createServer from '@inertiajs/vue3/server';
import { createSSRApp, h } from 'vue';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { renderToString } from 'vue/server-renderer';
import { ZiggyVue } from 'ziggy-js';
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

createServer(
  (page) =>
    createInertiaApp({
      page,
      render: renderToString,
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
      setup: ({ App, props, plugin }) =>
        createSSRApp({ render: () => h(App, props) })
          .provide('appName', appName)
          .use(plugin)
          .use(ZiggyVue, {
            ...page.props.ziggy,
            location: new URL(page.props.ziggy.location),
          }),
    }),
  { cluster: true },
);
