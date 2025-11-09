# Shared Components & Ziggy

This document describes the minimal steps required to expose the core `AppLayout.vue` and the shared Ziggy `route()` helper so Inertia pages that live inside vendor packages (such as `vendor/**/package-**`) can consume them without duplicating code or publishing npm packages.

## Core

1. **Create a public export surface**  
   - Add `resources/js/core/index.ts` with:
     ```ts
     export { default as AppLayout } from '@/layouts/AppLayout.vue';
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

4. **Rebuild assets**  
   - Run `npm run build` (or `npm run dev`) so Vite resolves the new alias during local development and production builds.

## Package integration steps

1. Import the core layout (and helper) from the shared alias:
   ```vue
   <script setup>
   import { AppLayout, route } from '@redae/core';
   </script>
   ```

2. Register the layout on the page component (Options API-compatible via `<script setup>`):
   ```ts
   defineOptions({
     layout: AppLayout,
   });
   ```

3. Use the shared `route()` helper anywhere inside the package page, e.g.:
   ```ts
   const portalHref = computed(() => props.billingPortalUrl ?? route('package-**.index'));
   ```

4. Keep the rest of the page logic unchanged. Because both the layout and Ziggy helpers live in the host app, no extra build configuration is needed inside the package.

## Next steps for custom package.

1. **Share more UI primitives (optional)**  
   - Import additional components from the same alias once the core exports them (e.g., buttons, cards). Follow the same `defineOptions` pattern or standard component registration.

2. **Verify rendering**  
   - Visit `package-**.index` and confirm the page renders with the host AppLayout and that `route()` resolves both package and core route names.

3. **Document the dependency**  
   - Note in the package README that it expects the host app to expose `@redae/core` so other developers understand the coupling and available helpers.

These steps keep the core agnostic while letting vendor packages piggyback on the same layout, Ziggy helpers, and future shared UI pieces without extra build tooling.
