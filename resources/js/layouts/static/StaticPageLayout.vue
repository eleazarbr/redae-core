<script setup lang="ts">
import AppLogoIcon from '@/components/AppLogoIcon.vue';

withDefaults(
    defineProps<{
        title: string;
        description?: string;
    }>(),
    {
        description: undefined,
    },
);
</script>

<template>
    <section class="flex w-full justify-center px-4 py-12 sm:px-6 lg:px-8">
        <div class="flex w-full max-w-5xl flex-col gap-10">
            <header class="flex flex-col items-center gap-4 text-center">
                <div class="flex h-12 w-12 items-center justify-center rounded-full bg-muted text-primary">
                    <slot name="icon">
                        <AppLogoIcon class="h-7 w-7" />
                    </slot>
                </div>
                <div class="space-y-2">
                    <h1 class="text-3xl font-semibold tracking-tight sm:text-4xl">{{ title }}</h1>
                    <p v-if="description" class="text-base text-muted-foreground sm:text-lg">
                        {{ description }}
                    </p>
                </div>
            </header>

            <div class="overflow-hidden rounded-3xl border border-border bg-card shadow-sm">
                <div class="mx-auto w-full max-w-3xl px-6 py-10 sm:px-8 sm:py-12 lg:px-12">
                    <slot />
                </div>
            </div>
        </div>
    </section>
</template>
