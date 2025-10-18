<?php

return [
    'title' => 'Configuración de la compañía',
    'section' => [
        'title' => 'Compañía',
        'description' => 'Administra la información de tu compañía y los datos de facturación.',
    ],
    'breadcrumbs' => [
        'index' => 'Compañía',
    ],
    'navbar' => [
        'general' => 'General',
    ],
    'general' => [
        'title' => 'Información de la compañía',
        'description' => 'Actualiza los datos principales de tu compañía.',
    ],
    'billing' => [
        'title' => 'Dirección de facturación',
        'description' => 'Información utilizada para facturas y recibos.',
    ],
    'form' => [
        'labels' => [
            'name' => 'Nombre de la compañía',
            'domain' => 'Dominio',
            'tax_id' => 'RFC / NIF',
            'country' => 'País (ISO)',
            'billing_line1' => 'Dirección',
            'billing_city' => 'Ciudad',
            'billing_state' => 'Estado / Provincia',
            'billing_postal_code' => 'Código postal',
        ],
        'placeholders' => [
            'name' => 'Acme S.A.',
            'domain' => 'app.ejemplo.com',
            'tax_id' => 'RFC / NIF',
            'country' => 'MX',
            'billing_line1' => 'Av. Principal 123',
            'billing_city' => 'Monterrey',
            'billing_state' => 'Nuevo León',
            'billing_postal_code' => '64000',
        ],
    ],
];
