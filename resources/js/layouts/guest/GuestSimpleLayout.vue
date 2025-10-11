<script setup lang="ts">
import TopNavbar from '@/components/TopNavbar.vue';
</script>

<template>
  <div class="flex min-h-screen flex-col items-center bg-[#FDFDFC] p-6 lg:justify-center lg:p-8 dark:bg-[#0a0a0a]">
    <div class="text-[#1b1b18]">
      <TopNavbar />
    </div>
    <slot />
  </div>
</template>
