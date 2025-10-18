<script setup lang="ts">
import { computed } from 'vue';
import { Form, Head } from '@inertiajs/vue3';

import HeadingSmall from '@/components/HeadingSmall.vue';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Select } from '@/components/ui/select';
import { Label } from '@/components/ui/label';
import { Separator } from '@/components/ui/separator';
import AppLayout from '@/layouts/AppLayout.vue';
import CompanyLayout from '@/layouts/company/Layout.vue';
import { AMERICAS_COUNTRIES, type CountryRegion } from '@/lib/countries';
import { type BreadcrumbItem, type Company } from '@/types';

interface Props {
  company: Company;
  status?: string;
}

defineProps<Props>();

const breadcrumbItems: BreadcrumbItem[] = [
  {
    title: 'company.breadcrumbs.index',
    href: '/company',
  },
];

const regionLabels: Record<CountryRegion, string> = {
  'north-america': 'Norteamérica',
  'central-america': 'Centroamérica',
  'south-america': 'Sudamérica',
  caribbean: 'Caribe',
};

const regionOrder: readonly CountryRegion[] = [
  'north-america',
  'central-america',
  'south-america',
  'caribbean',
];

const countryGroups = computed(() =>
  regionOrder
    .map((region) => ({
      region,
      label: regionLabels[region],
      options: AMERICAS_COUNTRIES.filter((country) => country.region === region).sort(
        (a, b) => a.name.localeCompare(b.name, 'es'),
      ),
    }))
    .filter(({ options }) => options.length > 0),
);
</script>

<template>
  <AppLayout :breadcrumbs="breadcrumbItems">
    <Head :title="$t('company.title')" />

    <CompanyLayout>
      <div class="flex flex-col space-y-6">
        <HeadingSmall
          :title="$t('company.general.title')"
          :description="$t('company.general.description')"
        />

        <Form
          method="patch"
          :action="route('company.update')"
          class="space-y-6"
          v-slot="{ errors, processing, recentlySuccessful }"
        >
          <div class="grid gap-2">
            <Label for="name">
              {{ $t('company.form.labels.name') }}
            </Label>
            <Input
              id="name"
              class="mt-1 block w-full"
              name="name"
              :default-value="company.name"
              required
              :placeholder="$t('company.form.placeholders.name')"
            />
            <InputError
              class="mt-2"
              :message="errors.name"
            />
          </div>

          <div class="grid gap-2">
            <Label for="domain">
              {{ $t('company.form.labels.domain') }}
            </Label>
            <Input
              id="domain"
              class="mt-1 block w-full"
              name="domain"
              :default-value="company.domain ?? ''"
              :placeholder="$t('company.form.placeholders.domain')"
            />
            <InputError
              class="mt-2"
              :message="errors.domain"
            />
          </div>

          <div class="grid gap-2">
            <Label for="tax_id">
              {{ $t('company.form.labels.tax_id') }}
            </Label>
            <Input
              id="tax_id"
              class="mt-1 block w-full"
              name="tax_id"
              :default-value="company.tax_id ?? ''"
              :placeholder="$t('company.form.placeholders.tax_id')"
            />
            <InputError
              class="mt-2"
              :message="errors.tax_id"
            />
          </div>

          <div class="grid gap-2">
            <Label for="country">
              {{ $t('company.form.labels.country') }}
            </Label>
            <Select
              id="country"
              class="mt-1 block w-full"
              name="country"
              :default-value="company.country ?? ''"
            >
              <template
                v-for="group in countryGroups"
                :key="group.region"
              >
                <optgroup :label="group.label">
                  <option
                    v-for="country in group.options"
                    :key="country.code"
                    :value="country.code"
                  >
                    {{ country.name }}
                  </option>
                </optgroup>
              </template>
            </Select>
            <InputError
              class="mt-2"
              :message="errors.country"
            />
          </div>

          <Separator class="my-4" />

          <HeadingSmall
            :title="$t('company.billing.title')"
            :description="$t('company.billing.description')"
          />

          <div class="grid gap-2">
            <Label for="billing_line1">
              {{ $t('company.form.labels.billing_line1') }}
            </Label>
            <Input
              id="billing_line1"
              class="mt-1 block w-full"
              name="billing_address[line1]"
              :default-value="company.billing_address?.line1 ?? ''"
              :placeholder="$t('company.form.placeholders.billing_line1')"
            />
            <InputError
              class="mt-2"
              :message="errors['billing_address.line1']"
            />
          </div>

          <div class="grid gap-2">
            <Label for="billing_city">
              {{ $t('company.form.labels.billing_city') }}
            </Label>
            <Input
              id="billing_city"
              class="mt-1 block w-full"
              name="billing_address[city]"
              :default-value="company.billing_address?.city ?? ''"
              :placeholder="$t('company.form.placeholders.billing_city')"
            />
            <InputError
              class="mt-2"
              :message="errors['billing_address.city']"
            />
          </div>

          <div class="grid gap-2">
            <Label for="billing_state">
              {{ $t('company.form.labels.billing_state') }}
            </Label>
            <Input
              id="billing_state"
              class="mt-1 block w-full"
              name="billing_address[state]"
              :default-value="company.billing_address?.state ?? ''"
              :placeholder="$t('company.form.placeholders.billing_state')"
            />
            <InputError
              class="mt-2"
              :message="errors['billing_address.state']"
            />
          </div>

          <div class="grid gap-2">
            <Label for="billing_postal_code">
              {{ $t('company.form.labels.billing_postal_code') }}
            </Label>
            <Input
              id="billing_postal_code"
              class="mt-1 block w-full"
              name="billing_address[postal_code]"
              :default-value="company.billing_address?.postal_code ?? ''"
              :placeholder="$t('company.form.placeholders.billing_postal_code')"
            />
            <InputError
              class="mt-2"
              :message="errors['billing_address.postal_code']"
            />
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
                v-show="recentlySuccessful || status === 'company-updated'"
                class="text-sm text-neutral-600"
              >
                {{ $t('common.messages.saved') }}
              </p>
            </Transition>
          </div>
        </Form>
      </div>
    </CompanyLayout>
  </AppLayout>
</template>
