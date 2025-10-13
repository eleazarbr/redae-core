<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Google Tag Manager Configuration
    |--------------------------------------------------------------------------
    |
    | Control whether Google Tag Manager should be injected and which container
    | ID to use. GTM can be enabled in any environment, including local or
    | production, by setting the corresponding environment variables.
    |
    */

    'enabled' => env('GTM_ENABLED', false),

    'container_id' => env('GTM_CONTAINER_ID'),
];
