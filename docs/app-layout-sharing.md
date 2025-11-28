# Shared Components, Ziggy & i18n

This document summarizes how the host application exposes its layout, routing helper, and i18n utilities so any custom package living under `vendor/**` can consume the same UI primitives without separate builds or npm publications.

## Core

1. **Create a public export surface**  
   - Add `resources/js/core/index.ts` with:
     ```ts
     export { default as AppLayout } from '@/layouts/AppLayout.vue';
     export { trans } from 'laravel-vue-i18n';
     export { route, useRoute } from 'ziggy-js';
     ```

2. **Register a Vite alias for consumers**  
   - In `vite.config.ts`, import `fileURLToPath`/`URL` from `node:url`.  
   - Extend `resolve.alias` with `@redae/core: fileURLToPath(new URL('./resources/js/core', import.meta.url))`.

3. **Mirror the alias for TypeScript tooling**  
   - Update `tsconfig.json` paths to include:  
     ```json
     "@redae/core": ["./resources/js/core/index.ts"],
     "@redae/core/*": ["./resources/js/core/*"]
     ```

4. **Keep i18n in sync**  
   - Publish each custom package language folder into `lang/vendor/{package}` (the default Laravel location).  
   - The existing `laravel-vue-i18n` Vite plugin will auto-convert PHP arrays from both the core (`lang/{locale}`) and vendor overrides (`lang/vendor/{package}/{locale}`) into the runtime JSON consumed by Inertia. No extra configuration is required—just ensure `npm run dev` / `npm run build` runs after new strings are added.

5. **Rebuild assets**  
   - Run `npm run build` (or `npm run dev`) so Vite resolves the alias and regenerates the compiled translation JSON.

## Package integration steps

1. Import the core layout plus helpers from the shared alias:
   ```vue
   <script setup>
   import { AppLayout, route, trans } from '@redae/core';
   </script>
   ```

2. Register the layout on the page component (Options API-compatible via `<script setup>`):
   ```ts
   defineOptions({
     layout: AppLayout,
   });
   ```

3. Use the shared helpers inside the package code:
   ```ts
   const portalHref = computed(() => props.billingPortalUrl ?? route('custom-package.portal'));
   const localizedTitle = computed(() => trans('custom-package::company.billing.title'));
   ```

4. Keep the rest of the page logic unchanged. Because the layout, routing helper, and i18n instance live in the host app, no extra build configuration is needed in the custom package.

## Next steps for a custom package

1. **Share more UI primitives (optional)**  
   - Import additional components from the same alias once the core exports them (e.g., buttons, cards). Follow the same `defineOptions` pattern or standard component registration.

2. **Verify rendering**  
   - Visit the package routes (for example `custom-package.billing`) and confirm the page renders with the host AppLayout, `route()` resolves both package/core routes, and `$t` / `trans()` surface the published translations.

3. **Document the dependency**  
   - Note in the package README that it expects the host app to expose `@redae/core` so other developers understand the coupling and available helpers.

These steps keep the core agnostic while enabling any vendor/** custom package to reuse the same layout, Ziggy helper, and shared translation context without duplicating assets or publishing separate npm packages.
