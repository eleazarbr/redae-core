<script setup lang="ts">
import { SidebarGroup, SidebarGroupLabel, SidebarMenu, SidebarMenuButton, SidebarMenuItem } from '@/components/ui/sidebar';
import { resolveIcon } from '@/lib/icons';
import type { AppPageProps, NavItem } from '@/types';
import { Link, usePage } from '@inertiajs/vue3';

defineProps<{
  items: NavItem[];
}>();

const page = usePage<AppPageProps>();

const resolveIconComponent = (icon?: string) => resolveIcon(icon);

const isActive = (href: string): boolean => {
  if (! href) {
    return false;
  }

  return page.url?.startsWith(href);
};
</script>

<template>
  <SidebarGroup class="px-2 py-0">
    <SidebarGroupLabel>
      {{ $t('dashboard.sidebar.platform') }}
    </SidebarGroupLabel>
    <SidebarMenu>
      <SidebarMenuItem
        v-for="item in items"
        :key="item.href"
      >
        <SidebarMenuButton
          as-child
          :is-active="isActive(item.href)"
          :tooltip="$t(item.title)"
          >
          <Link :href="item.href">
            <component
              v-if="item.icon && resolveIconComponent(item.icon)"
              :is="resolveIconComponent(item.icon)"
            />
            <span>{{ $t(item.title) }}</span>
          </Link>
        </SidebarMenuButton>
      </SidebarMenuItem>
    </SidebarMenu>
  </SidebarGroup>
</template>
