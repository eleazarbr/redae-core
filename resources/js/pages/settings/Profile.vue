<script setup lang="ts">
import { Form, Head, Link, usePage } from '@inertiajs/vue3';

import DeleteUser from '@/components/DeleteUser.vue';
import HeadingSmall from '@/components/HeadingSmall.vue';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AppLayout from '@/layouts/AppLayout.vue';
import SettingsLayout from '@/layouts/settings/Layout.vue';
import { type BreadcrumbItem, type User } from '@/types';

interface Props {
  mustVerifyEmail: boolean;
  status?: string;
}

defineProps<Props>();

const breadcrumbItems: BreadcrumbItem[] = [
  {
    title: 'settings.title',
    href: '/settings/profile',
  },
];

const page = usePage();
const user = page.props.auth.user as User;
</script>

<template>
  <AppLayout :breadcrumbs="breadcrumbItems">
    <Head :title="$t('settings.title')" />

    <SettingsLayout>
      <div class="flex flex-col space-y-6">
        <HeadingSmall
          :title="$t('settings.profile.title')"
          :description="$t('settings.profile.description')"
        />

        <Form
          method="patch"
          :action="route('profile.update')"
          class="space-y-6"
          v-slot="{ errors, processing, recentlySuccessful }"
        >
          <div class="grid gap-2">
            <Label for="name">
              {{ $t('common.labels.name') }}
            </Label>
            <Input
              id="name"
              class="mt-1 block w-full"
              name="name"
              :default-value="user.name"
              required
              autocomplete="name"
              :placeholder="$t('common.placeholders.name')"
            />
            <InputError
              class="mt-2"
              :message="errors.name"
            />
          </div>

          <div class="grid gap-2">
            <Label for="email">
              {{ $t('common.labels.email') }}
            </Label>
            <Input
              id="email"
              type="email"
              class="mt-1 block w-full"
              name="email"
              :default-value="user.email"
              required
              autocomplete="username"
              :placeholder="$t('common.placeholders.email')"
            />
            <InputError
              class="mt-2"
              :message="errors.email"
            />
          </div>

          <div v-if="mustVerifyEmail && !user.email_verified_at">
            <p class="-mt-4 text-sm text-muted-foreground">
              Your email address is unverified.
              <Link
                :href="route('verification.send')"
                method="post"
                as="button"
                class="text-foreground underline decoration-neutral-300 underline-offset-4 transition-colors duration-300 ease-out hover:decoration-current! dark:decoration-neutral-500"
              >
                Click here to resend the verification email.
              </Link>
            </p>

            <div
              v-if="status === 'verification-link-sent'"
              class="mt-2 text-sm font-medium text-green-600"
            >
              A new verification link has been sent to your email address.
            </div>
          </div>

          <div class="flex items-center gap-4">
            <Button :disabled="processing">
              {{ $t('common.buttons.save') }}
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

      <DeleteUser />
    </SettingsLayout>
  </AppLayout>
</template>
