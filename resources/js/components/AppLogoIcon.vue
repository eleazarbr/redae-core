<script setup lang="ts">
import type { HTMLAttributes } from 'vue';

defineOptions({ inheritAttrs: false });

interface Props {
  className?: HTMLAttributes['class'];
  title?: string;
  decorative?: boolean; // true = aria-hidden.
}
const props = withDefaults(defineProps<Props>(), {
  decorative: true,
});
</script>

<template>
  <svg
    xmlns="http://www.w3.org/2000/svg"
    viewBox="0 0 40 40"
    :class="className"
    :aria-hidden="props.decorative ? 'true' : undefined"
    role="img"
    v-bind="$attrs"
    fill="none"
    stroke="currentColor"
    stroke-width="2"
    stroke-linecap="round"
    stroke-linejoin="round"
  >
    <title v-if="!props.decorative">{{ props.title }}</title>

    <!-- Square base -->
    <rect
      x="8"
      y="8"
      width="24"
      height="24"
      rx="4"
    />

    <!-- Rotated square to form icon -->
    <rect
      x="8"
      y="8"
      width="24"
      height="24"
      rx="4"
      transform="rotate(45 20 20)"
    />
  </svg>
</template>
