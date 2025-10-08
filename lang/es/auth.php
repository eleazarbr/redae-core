<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Authentication Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used during authentication for various
    | messages that we need to display to the user. You are free to modify
    | these language lines according to your application's requirements.
    |
    */

    'failed' => 'Estas credenciales no coinciden con nuestros registros.',
    'password' => 'La contraseña proporcionada es incorrecta.',
    'throttle' => 'Demasiados intentos de inicio de sesión. Por favor, inténtelo de nuevo en :seconds segundos.',

    'register' => [
        'title' => 'Crear una cuenta',
        'description' => 'Ingresa tus datos a continuación para crear tu cuenta',
        'head_title' => 'Registrarse',
        'company_name_label' => 'Nombre de la empresa',
        'company_name_placeholder' => 'Nombre de la empresa',
        'name_label' => 'Nombre',
        'full_name_placeholder' => 'Nombre',
        'email_label' => 'Correo electrónico',
        'email_placeholder' => 'correo@ejemplo.com',
        'password_label' => 'Contraseña',
        'password_placeholder' => 'Contraseña',
        'password_confirmation_label' => 'Confirmar contraseña',
        'password_confirmation_placeholder' => 'Confirmar contraseña',
        'submit' => 'Crear cuenta',
        'login_prompt' => '¿Ya tienes una cuenta?',
        'login_link' => 'Iniciar sesión',
        'terms_and_privacy_label' => 'Acepto los :terms_link y la :privacy_link',
        'terms_link' => 'Términos y Condiciones',
        'privacy_link' => 'Política de Privacidad',
    ],
    'login' => [
        'title' => 'Inicia sesión en tu cuenta',
        'description' => 'Ingresa tu correo y contraseña para iniciar sesión',
        'head_title' => 'Iniciar sesión',
        'email_label' => 'Correo electrónico',
        'email_placeholder' => 'correo@ejemplo.com',
        'password_label' => 'Contraseña',
        'password_placeholder' => 'Contraseña',
        'forgot_password_link' => '¿Olvidaste tu contraseña?',
        'remember_me' => 'Recuérdame',
        'submit' => 'Iniciar sesión',
        'register_prompt' => '¿No tienes una cuenta?',
        'register_link' => 'Regístrate',
    ],
    'forgot_password' => [
        'title' => '¿Olvidaste tu contraseña?',
        'description' => 'Ingresa tu correo para recibir un enlace de restablecimiento de contraseña',
        'head_title' => '¿Olvidaste tu contraseña?',
        'email_label' => 'Correo electrónico',
        'email_placeholder' => 'correo@ejemplo.com',
        'submit' => 'Enviar enlace para restablecer contraseña',
        'login_prompt' => 'O regresa a',
        'login_link' => 'iniciar sesión',
        'reset_link_sent' => 'Se enviará un enlace de restablecimiento si la cuenta existe.',
    ],
];
