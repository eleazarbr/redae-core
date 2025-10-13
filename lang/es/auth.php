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
        'last_name_label' => 'Apellido',
        'last_name_placeholder' => 'Apellido',
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
    'verify_email' => [
        'title' => 'Verifica tu correo electrónico',
        'description' => 'Por favor verifica tu dirección de correo electrónico haciendo clic en el enlace que acabamos de enviarte.',
        'head_title' => 'Verificación de correo electrónico',
        'link_sent' => 'Se ha enviado un nuevo enlace de verificación a la dirección de correo que proporcionaste durante el registro.',
        'submit' => 'Reenviar correo de verificación',
        'logout' => 'Cerrar sesión',
    ],
    'notifications' => [
        'greeting' => '¡Hola!',
        'salutation' => 'Saludos.',
        'action_text' => 'Si tienes problemas para hacer clic en el botón ":action_text", copia y pega la siguiente URL en tu navegador web:',
        'verify_email' => [
            'subject' => 'Verifica tu dirección de correo electrónico',
            'line_1' => 'Haz clic en el botón de abajo para verificar tu dirección de correo electrónico.',
            'action' => 'Verificar correo electrónico',
            'line_2' => 'Si no creaste una cuenta, no es necesario realizar ninguna acción.',
        ],
        'reset_password' => [
            'subject' => 'Notificación de restablecimiento de contraseña',
            'line_1' => 'Recibiste este correo porque recibimos una solicitud de restablecimiento de contraseña para tu cuenta.',
            'action' => 'Restablecer contraseña',
            'line_2' => 'Este enlace de restablecimiento de contraseña expirará en :count minutos.',
            'line_3' => 'Si no solicitaste un restablecimiento de contraseña, no es necesario realizar ninguna acción.',
        ],
    ],
];
