<script setup lang="ts">
import { SidebarGroup, SidebarGroupContent, SidebarMenu, SidebarMenuButton, SidebarMenuItem } from '@/components/ui/sidebar';
import { resolveIcon } from '@/lib/icons';
import { type NavItem } from '@/types';

interface Props {
  items: NavItem[];
  class?: string;
}

const props = defineProps<Props>();

const resolveIconComponent = (icon?: string) => resolveIcon(icon);
</script>

<template>
  <SidebarGroup :class="`group-data-[collapsible=icon]:p-0 ${$props.class || ''}`">
    <SidebarGroupContent>
      <SidebarMenu>
        <SidebarMenuItem
          v-for="item in props.items"
          :key="item.href"
        >
          <SidebarMenuButton
            class="text-neutral-600 hover:text-neutral-800 dark:text-neutral-300 dark:hover:text-neutral-100"
            as-child
          >
            <a
              :href="item.href"
              target="_blank"
              rel="noopener noreferrer"
            >
              <component
                v-if="item.icon && resolveIconComponent(item.icon)"
                :is="resolveIconComponent(item.icon)"
              />
              <span>{{ $t(item.title) }}</span>
            </a>
          </SidebarMenuButton>
        </SidebarMenuItem>
      </SidebarMenu>
    </SidebarGroupContent>
  </SidebarGroup>
</template>
