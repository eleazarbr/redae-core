<script setup lang="ts">
import type { AppPageProps } from '@/types';
import { Link, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

const page = usePage<AppPageProps>();
const isAuthenticated = computed(() => Boolean(page.props.auth.user));
</script>

<template>
  <header class="mb-6 w-full max-w-[335px] text-sm not-has-[nav]:hidden lg:max-w-4xl">
    <nav class="flex items-center justify-between gap-4">
      <div class="flex items-center gap-4">
        <Link
          v-if="isAuthenticated"
          :href="route('dashboard')"
          class="inline-block rounded-sm border border-[#19140035] px-5 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#1915014a] dark:border-[#3E3E3A] dark:text-[#EDEDEC] dark:hover:border-[#62605b]"
        >
          {{ $t('navbar.dashboard') }}
        </Link>
        <template v-else>
          <Link
            :href="route('login')"
            class="inline-block rounded-sm border border-transparent px-5 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#19140035] dark:text-[#EDEDEC] dark:hover:border-[#3E3E3A]"
          >
            {{ $t('navbar.login') }}
          </Link>
          <Link
            :href="route('register')"
            class="inline-block rounded-sm border border-[#19140035] px-5 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#1915014a] dark:border-[#3E3E3A] dark:text-[#EDEDEC] dark:hover:border-[#62605b]"
          >
            {{ $t('navbar.register') }}
          </Link>
        </template>
      </div>
    </nav>
  </header>
</template>
