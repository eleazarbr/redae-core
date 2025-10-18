export type CountryRegion =
  | 'north-america'
  | 'central-america'
  | 'south-america'
  | 'caribbean'

export interface CountryRecord {
  code: string
  region: CountryRegion
  name: string
}

export const AMERICAS_COUNTRIES: readonly CountryRecord[] = [
  { code: 'AG', region: 'caribbean', name: 'Antigua y Barbuda' },
  { code: 'AR', region: 'south-america', name: 'Argentina' },
  { code: 'BB', region: 'caribbean', name: 'Barbados' },
  { code: 'BO', region: 'south-america', name: 'Bolivia' },
  { code: 'BR', region: 'south-america', name: 'Brasil' },
  { code: 'BS', region: 'caribbean', name: 'Bahamas' },
  { code: 'BZ', region: 'central-america', name: 'Belice' },
  { code: 'CA', region: 'north-america', name: 'Canadá' },
  { code: 'CL', region: 'south-america', name: 'Chile' },
  { code: 'CO', region: 'south-america', name: 'Colombia' },
  { code: 'CR', region: 'central-america', name: 'Costa Rica' },
  { code: 'CU', region: 'caribbean', name: 'Cuba' },
  { code: 'DM', region: 'caribbean', name: 'Dominica' },
  { code: 'DO', region: 'caribbean', name: 'República Dominicana' },
  { code: 'EC', region: 'south-america', name: 'Ecuador' },
  { code: 'GT', region: 'central-america', name: 'Guatemala' },
  { code: 'GD', region: 'caribbean', name: 'Granada' },
  { code: 'GY', region: 'south-america', name: 'Guyana' },
  { code: 'HT', region: 'caribbean', name: 'Haití' },
  { code: 'HN', region: 'central-america', name: 'Honduras' },
  { code: 'JM', region: 'caribbean', name: 'Jamaica' },
  { code: 'KN', region: 'caribbean', name: 'San Cristóbal y Nieves' },
  { code: 'LC', region: 'caribbean', name: 'Santa Lucía' },
  { code: 'MX', region: 'north-america', name: 'México' },
  { code: 'NI', region: 'central-america', name: 'Nicaragua' },
  { code: 'PA', region: 'central-america', name: 'Panamá' },
  { code: 'PE', region: 'south-america', name: 'Perú' },
  { code: 'PY', region: 'south-america', name: 'Paraguay' },
  { code: 'SR', region: 'south-america', name: 'Surinam' },
  { code: 'SV', region: 'central-america', name: 'El Salvador' },
  { code: 'TT', region: 'caribbean', name: 'Trinidad y Tobago' },
  { code: 'US', region: 'north-america', name: 'Estados Unidos' },
  { code: 'UY', region: 'south-america', name: 'Uruguay' },
  { code: 'VC', region: 'caribbean', name: 'San Vicente y las Granadinas' },
  { code: 'VE', region: 'south-america', name: 'Venezuela' },
] as const

export type CountryCode = (typeof AMERICAS_COUNTRIES)[number]['code']
