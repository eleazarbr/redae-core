<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import SettingsLayout from '@/layouts/settings/Layout.vue';
import { Form, Head } from '@inertiajs/vue3';
import { ref } from 'vue';

import HeadingSmall from '@/components/HeadingSmall.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { type BreadcrumbItem } from '@/types';

const breadcrumbItems: BreadcrumbItem[] = [
  {
    title: 'settings.password.title',
    href: '/settings/password',
  },
];

const passwordInput = ref<HTMLInputElement | null>(null);
const currentPasswordInput = ref<HTMLInputElement | null>(null);
</script>

<template>
  <AppLayout :breadcrumbs="breadcrumbItems">
    <Head :title="$t('settings.password.title')" />

    <SettingsLayout>
      <div class="space-y-6">
        <HeadingSmall
          :title="$t('settings.password.heading')"
          :description="$t('settings.password.description')"
        />

        <Form
          method="put"
          :action="route('password.update')"
          :options="{
            preserveScroll: true,
          }"
          reset-on-success
          :reset-on-error="['password', 'password_confirmation', 'current_password']"
          class="space-y-6"
          v-slot="{ errors, processing, recentlySuccessful }"
        >
          <div class="grid gap-2">
            <Label for="current_password">
              {{ $t('common.labels.current_password') }}
            </Label>
            <Input
              id="current_password"
              ref="currentPasswordInput"
              name="current_password"
              type="password"
              class="mt-1 block w-full"
              autocomplete="current-password"
              :placeholder="$t('common.placeholders.current_password')"
            />
            <InputError :message="errors.current_password" />
          </div>

          <div class="grid gap-2">
            <Label for="password">
              {{ $t('common.labels.new_password') }}
            </Label>
            <Input
              id="password"
              ref="passwordInput"
              name="password"
              type="password"
              class="mt-1 block w-full"
              autocomplete="new-password"
              :placeholder="$t('common.placeholders.new_password')"
            />
            <InputError :message="errors.password" />
          </div>

          <div class="grid gap-2">
            <Label for="password_confirmation">
              {{ $t('common.labels.password_confirmation') }}
            </Label>
            <Input
              id="password_confirmation"
              name="password_confirmation"
              type="password"
              class="mt-1 block w-full"
              autocomplete="new-password"
              :placeholder="$t('common.placeholders.password_confirmation')"
            />
            <InputError :message="errors.password_confirmation" />
          </div>

          <div class="flex items-center gap-4">
            <Button :disabled="processing">
              {{ $t('common.buttons.save_password') }}
            </Button>

            <Transition
              enter-active-class="transition ease-in-out"
              enter-from-class="opacity-0"
              leave-active-class="transition ease-in-out"
              leave-to-class="opacity-0"
            >
              <p
                v-show="recentlySuccessful"
                class="text-sm text-neutral-600"
              >
                {{ $t('common.messages.saved') }}
              </p>
            </Transition>
          </div>
        </Form>
      </div>
    </SettingsLayout>
  </AppLayout>
</template>
