import { clsx, type ClassValue } from 'clsx';
import { twMerge } from 'tailwind-merge';

export function cn(...inputs: ClassValue[]) {
  return twMerge(clsx(inputs));
}

export function formatTitle(title: string | null | undefined, appName: string) {
  return title ? `${title} - ${appName}` : appName;
}
