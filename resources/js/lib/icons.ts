import type { Component } from 'vue';
import * as LucideIcons from 'lucide-vue-next';

/**
 * Resolve a Lucide icon component by its exported name.
 */
export function resolveIcon(name?: string): Component | undefined {
  if (!name) {
    return undefined;
  }

  const icons = LucideIcons as unknown as Record<string, Component>;

  return icons[name];
}

