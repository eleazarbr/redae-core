# Shared AppLayout POC

This document describes the minimal steps required to expose the core `AppLayout.vue` so Inertia pages that live inside vendor packages (such as `vendor/**/package-**`) can consume it without duplicating code or publishing npm packages.

## Core

1. **Create a public export surface**  
   - Add `resources/js/core/index.ts` with `export { default as AppLayout } from '@/layouts/AppLayout.vue';`.

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

1. Import the core layout from the shared alias:
   ```vue
   <script setup>
   import { AppLayout } from '@redae/core';
   </script>
   ```

2. Register the layout on the page component (Options API-compatible via `<script setup>`):
   ```ts
   defineOptions({
     layout: AppLayout,
   });
   ```

3. Keep the rest of the page logic unchanged. Because the layout lives in the host app, no extra build configuration is needed inside the package.

## Next steps for `package-**`

1. **Share more UI primitives (optional)**  
   - Import additional components from the same alias once the core exports them (e.g., buttons, cards). Follow the same `defineOptions` pattern or standard component registration.

2. **Verify rendering**  
   - Visit the package route (`package-**.index`) and confirm the page renders with the host AppLayout (sidebar, chrome, etc.).

3. **Document the dependency**  
   - Note in the package README that it expects the host app to expose `@redae/core` so other developers understand the coupling.

These steps keep the core agnostic while letting vendor packages piggyback on the same layout and future shared UI pieces without extra build tooling.
