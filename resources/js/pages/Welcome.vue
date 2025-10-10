<script setup lang="ts">
import GuestLayout from '@/layouts/GuestLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

defineOptions({
  layout: GuestLayout,
});
</script>

<template>
  <Head title="Welcome">
    <link
      rel="preconnect"
      href="https://rsms.me/"
    />
    <link
      rel="stylesheet"
      href="https://rsms.me/inter/inter.css"
    />
  </Head>
  <div class="flex w-full items-center justify-center opacity-100 transition-opacity duration-750 lg:grow starting:opacity-0">

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
  </div>
</template>
