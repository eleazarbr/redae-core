<?php

return [
    'title' => 'Company settings',
    'section' => [
        'title' => 'Company',
        'description' => 'Manage your company information and billing details.',
    ],
    'breadcrumbs' => [
        'index' => 'Company',
    ],
    'navbar' => [
        'general' => 'General',
    ],
    'general' => [
        'title' => 'Company information',
        'description' => 'Update the core details of your company.',
    ],
    'billing' => [
        'title' => 'Billing address',
        'description' => 'Information used for invoices and receipts.',
    ],
    'form' => [
        'labels' => [
            'name' => 'Company name',
            'domain' => 'Domain',
            'tax_id' => 'Tax ID',
            'country' => 'Country (ISO)',
            'billing_line1' => 'Street address',
            'billing_city' => 'City',
            'billing_state' => 'State / Province',
            'billing_postal_code' => 'Postal code',
        ],
        'placeholders' => [
            'name' => 'Acme Inc.',
            'domain' => 'app.example.com',
            'tax_id' => 'RFC / VAT',
            'country' => 'US',
            'billing_line1' => '123 Main Street',
            'billing_city' => 'Austin',
            'billing_state' => 'Texas',
            'billing_postal_code' => '73301',
        ],
    ],
];
