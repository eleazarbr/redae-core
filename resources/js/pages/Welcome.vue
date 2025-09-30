<script setup lang="ts">
import GuestLayout from '@/layouts/GuestLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

defineOptions({
    layout: GuestLayout,
});
</script>

<template>
    <Head title="Welcome">
        <link rel="preconnect" href="https://rsms.me/" />
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
    </Head>
    <div class="flex w-full items-center justify-center opacity-100 transition-opacity duration-750 lg:grow starting:opacity-0">
        <main class="w-full max-w-4xl space-y-16 rounded-2xl border border-[#19140022] bg-white/80 p-8 shadow-[0_40px_80px_-48px_rgba(0,0,0,0.45)] backdrop-blur lg:p-16 dark:border-[#fffaed2d] dark:bg-[#161615]/90">
            <section class="flex flex-col items-center gap-4 text-center">
                <span class="inline-flex items-center gap-2 rounded-full border border-[#19140022] px-4 py-1 text-xs font-semibold uppercase tracking-[0.28em] text-[#6f6e6b] dark:border-[#fffaed2d] dark:text-[#A1A09A]">
                    Redae Core
                </span>
                <h1 class="text-3xl font-semibold text-[#1b1b18] sm:text-4xl lg:text-5xl dark:text-[#EDEDEC]">
                    Construye tus aplicaciones más rápido.
                </h1>
                <p class="max-w-2xl text-sm text-[#55544f] sm:text-base dark:text-[#A1A09A]">
                    Redae Core es la base común para todas tus experiencias digitales. Mantén autenticación, estilo y componentes consistentes mientras te enfocas en la lógica de cada producto.
                </p>
                <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
                    <Link
                        :href="route('login')"
                        class="inline-flex items-center justify-center rounded-md bg-[#1b1b18] px-6 py-2 text-sm font-medium text-white shadow-sm transition hover:bg-black dark:bg-[#EDEDEC] dark:text-[#1C1C1A] dark:hover:bg-white"
                    >
                        Entra al panel
                    </Link>
                    <a
                        href="https://github.com/eleazarbr"
                        target="_blank"
                        rel="noreferrer"
                        class="inline-flex items-center justify-center rounded-md border border-[#19140035] px-6 py-2 text-sm font-medium text-[#1b1b18] transition hover:border-[#1915014a] dark:border-[#3E3E3A] dark:text-[#EDEDEC] dark:hover:border-[#62605b]"
                    >
                        Ver documentación
                    </a>
                </div>
            </section>

            <section class="rounded-xl border border-[#19140022] bg-white/75 p-6 text-center dark:border-[#3E3E3A] dark:bg-[#1F1F1E]">
                <h2 class="text-2xl font-semibold text-[#1b1b18] dark:text-[#EDEDEC]">¿Listo para lanzar la siguiente app?</h2>
                <p class="mt-3 text-sm text-[#55544f] dark:text-[#A1A09A]">
                    Crea una cuenta de invitado para compartir la demo o invita a tu equipo para empezar a configurar los módulos base.
                </p>
                <div class="mt-6 flex flex-col justify-center gap-3 sm:flex-row">
                    <Link
                        :href="route('register')"
                        class="inline-flex items-center justify-center rounded-md bg-[#f53003] px-6 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-[#d42a02] dark:bg-[#FF4433] dark:hover:bg-[#ff5c4d]"
                    >
                        Crear cuenta
                    </Link>
                    <Link
                        :href="route('dashboard')"
                        class="inline-flex items-center justify-center rounded-md border border-[#19140035] px-6 py-2 text-sm font-medium text-[#1b1b18] transition hover:border-[#1915014a] dark:border-[#3E3E3A] dark:text-[#EDEDEC] dark:hover:border-[#62605b]"
                    >
                        Ir al dashboard
                    </Link>
                </div>
            </section>
        </main>
    </div>
</template>
