<script setup lang="ts">
import { Form } from '@inertiajs/vue3';
import { ref } from 'vue';

// Components
import HeadingSmall from '@/components/HeadingSmall.vue';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import {
  Dialog,
  DialogClose,
  DialogContent,
  DialogDescription,
  DialogFooter,
  DialogHeader,
  DialogTitle,
  DialogTrigger,
} from '@/components/ui/dialog';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';

const passwordInput = ref<HTMLInputElement | null>(null);
</script>

<template>
  <div class="space-y-6">
    <HeadingSmall
      :title="$t('settings.profile.delete_account')"
      :description="$t('settings.profile.delete_account_description')"
    />
    <div class="space-y-4 rounded-lg border border-red-100 bg-red-50 p-4 dark:border-red-200/10 dark:bg-red-700/10">
      <div class="relative space-y-0.5 text-red-600 dark:text-red-100">
        <p class="font-medium">{{ $t('common.labels.warning') }}</p>
        <p class="text-sm">{{ $t('common.labels.please_proceed_with_caution') }}</p>
      </div>
      <Dialog>
        <DialogTrigger as-child>
          <Button variant="destructive">
            {{ $t('settings.profile.delete_account_button') }}
          </Button>
        </DialogTrigger>
        <DialogContent>
          <Form
            method="delete"
            :action="route('profile.destroy')"
            reset-on-success
            @error="() => passwordInput?.focus()"
            :options="{
              preserveScroll: true,
            }"
            class="space-y-6"
            v-slot="{ errors, processing, reset, clearErrors }"
          >
            <DialogHeader class="space-y-3">
              <DialogTitle>
                {{ $t('settings.profile.delete_account_confirm') }}
              </DialogTitle>
              <DialogDescription>
                {{ $t('settings.profile.delete_account_description') }}
              </DialogDescription>
            </DialogHeader>

            <div class="grid gap-2">
              <Label
                for="password"
                class="sr-only"
                >{{ $t('common.labels.password') }}</Label
              >
              <Input
                id="password"
                type="password"
                name="password"
                ref="passwordInput"
                :placeholder="$t('common.placeholders.password')"
              />
              <InputError :message="errors.password" />
            </div>

            <DialogFooter class="gap-2">
              <DialogClose as-child>
                <Button
                  variant="secondary"
                  @click="
                    () => {
                      clearErrors();
                      reset();
                    }
                  "
                >
                  {{ $t('common.buttons.cancel') }}
                </Button>
              </DialogClose>

              <Button
                type="submit"
                variant="destructive"
                :disabled="processing"
              >
                {{ $t('settings.profile.delete_account_button') }}
              </Button>
            </DialogFooter>
          </Form>
        </DialogContent>
      </Dialog>
    </div>
  </div>
</template>
