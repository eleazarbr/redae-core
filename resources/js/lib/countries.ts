export type CountryRegion =
  | 'north-america'
  | 'central-america'
  | 'south-america'
  | 'caribbean'

export interface CountryRecord {
  code: string
  region: CountryRegion
}

export const AMERICAS_COUNTRIES: readonly CountryRecord[] = [
  { code: 'AG', region: 'caribbean' },
  { code: 'AR', region: 'south-america' },
  { code: 'BB', region: 'caribbean' },
  { code: 'BO', region: 'south-america' },
  { code: 'BR', region: 'south-america' },
  { code: 'BS', region: 'caribbean' },
  { code: 'BZ', region: 'central-america' },
  { code: 'CA', region: 'north-america' },
  { code: 'CL', region: 'south-america' },
  { code: 'CO', region: 'south-america' },
  { code: 'CR', region: 'central-america' },
  { code: 'CU', region: 'caribbean' },
  { code: 'DM', region: 'caribbean' },
  { code: 'DO', region: 'caribbean' },
  { code: 'EC', region: 'south-america' },
  { code: 'GT', region: 'central-america' },
  { code: 'GD', region: 'caribbean' },
  { code: 'GY', region: 'south-america' },
  { code: 'HT', region: 'caribbean' },
  { code: 'HN', region: 'central-america' },
  { code: 'JM', region: 'caribbean' },
  { code: 'KN', region: 'caribbean' },
  { code: 'LC', region: 'caribbean' },
  { code: 'MX', region: 'north-america' },
  { code: 'NI', region: 'central-america' },
  { code: 'PA', region: 'central-america' },
  { code: 'PE', region: 'south-america' },
  { code: 'PY', region: 'south-america' },
  { code: 'SR', region: 'south-america' },
  { code: 'SV', region: 'central-america' },
  { code: 'TT', region: 'caribbean' },
  { code: 'US', region: 'north-america' },
  { code: 'UY', region: 'south-america' },
  { code: 'VC', region: 'caribbean' },
  { code: 'VE', region: 'south-america' },
] as const

export type CountryCode = (typeof AMERICAS_COUNTRIES)[number]['code']
