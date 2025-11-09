import vue from '@vitejs/plugin-vue';
import tailwindcss from '@tailwindcss/vite';
import laravel from 'laravel-vite-plugin';
import i18n from 'laravel-vue-i18n/vite';
import { fileURLToPath, URL } from 'node:url';
import { defineConfig } from 'vite';

export default defineConfig({
    resolve: {
        alias: {
            '@redae/core': fileURLToPath(new URL('./resources/js/core', import.meta.url)),
        },
    },
    plugins: [
        laravel({
            input: ['resources/js/app.ts'],
            ssr: 'resources/js/ssr.ts',
            refresh: true,
        }),
        tailwindcss(),
        i18n(),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],
});
