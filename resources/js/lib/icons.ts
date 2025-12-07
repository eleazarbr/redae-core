import type { Component } from 'vue';
import { BookOpen, Building2, Folder, LayoutGrid } from 'lucide-vue-next';

const iconRegistry: Record<string, Component> = {
  BookOpen,
  Building2,
  Folder,
  LayoutGrid,
};

/**
 * Resolve a Lucide icon component by its exported name.
 */
export function resolveIcon(name?: string): Component | undefined {
  if (!name) {
    return undefined;
  }

  return iconRegistry[name];
}
