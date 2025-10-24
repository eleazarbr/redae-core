import { createInertiaApp } from '@inertiajs/vue3';
import createServer from '@inertiajs/vue3/server';
import { createSSRApp, h } from 'vue';
import { renderToString } from 'vue/server-renderer';
import { ZiggyVue } from 'ziggy-js';
import { formatTitle } from './lib/utils';
import { resolveInertia } from './registry';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createServer(
  (page) =>
    createInertiaApp({
      page,
      render: renderToString,
      title: (title) => formatTitle(title, appName),
      resolve: (name) => resolveInertia(name),
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
