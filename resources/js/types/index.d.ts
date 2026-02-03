import type { Config } from 'ziggy-js';

export interface Auth {
  user: User;
}

export interface BreadcrumbItem {
  title: string;
  href: string;
}

export interface NavItem {
  title: string;
  href: string;
  icon?: string;
  isActive?: boolean;
}

export type NavigationGroups = Record<string, NavItem[]>;

export type NavigationConfig = Record<string, NavigationGroups>;

export type AppPageProps<T extends Record<string, unknown> = Record<string, unknown>> = T & {
  name: string;
  quote: { message: string; author: string };
  auth: Auth;
  features: {
    auth: boolean;
  };
  ziggy: Config & { location: string };
  sidebarOpen: boolean;
  navigation: NavigationConfig;
};

export interface User {
  id: number;
  company_id: number;
  name: string;
  last_name: string | null;
  email: string;
  avatar?: string;
  email_verified_at: string | null;
  role: number;
  status: number;
  created_at: string;
  updated_at: string;
}

export interface CompanyBillingAddress {
  line1?: string | null;
  city?: string | null;
  state?: string | null;
  postal_code?: string | null;
}

export interface Company {
  id: number;
  name: string;
  slug: string;
  domain: string | null;
  tax_id: string | null;
  country: string | null;
  billing_address: CompanyBillingAddress | null;
}

export type BreadcrumbItemType = BreadcrumbItem;
