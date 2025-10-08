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

    'failed' => 'These credentials do not match our records.',
    'password' => 'The provided password is incorrect.',
    'throttle' => 'Too many login attempts. Please try again in :seconds seconds.',

    'register' => [
        'title' => 'Create an account',
        'description' => 'Enter your details below to create your account',
        'head_title' => 'Register',
        'company_name_label' => 'Company Name',
        'company_name_placeholder' => 'Company Name',
        'name_label' => 'Name',
        'full_name_placeholder' => 'Name',
        'email_label' => 'Email address',
        'email_placeholder' => 'email@example.com',
        'password_label' => 'Password',
        'password_placeholder' => 'Password',
        'password_confirmation_label' => 'Confirm password',
        'password_confirmation_placeholder' => 'Confirm password',
        'submit' => 'Create account',
        'login_prompt' => 'Already have an account?',
        'login_link' => 'Log in',
        'terms_and_privacy_label' => 'I agree to the :terms_link and :privacy_link',
        'terms_link' => 'Terms and Conditions',
        'privacy_link' => 'Privacy Policy',
    ],
    'login' => [
        'title' => 'Log in to your account',
        'description' => 'Enter your email and password below to log in',
        'head_title' => 'Log in',
        'email_label' => 'Email address',
        'email_placeholder' => 'email@example.com',
        'password_label' => 'Password',
        'password_placeholder' => 'Password',
        'forgot_password_link' => 'Forgot password?',
        'remember_me' => 'Remember me',
        'submit' => 'Log in',
        'register_prompt' => "Don't have an account?",
        'register_link' => 'Sign up',
    ],
    'forgot_password' => [
        'title' => 'Forgot password',
        'description' => 'Enter your email to receive a password reset link',
        'head_title' => 'Forgot password',
        'email_label' => 'Email address',
        'email_placeholder' => 'email@example.com',
        'submit' => 'Email password reset link',
        'login_prompt' => 'Or, return to',
        'login_link' => 'log in',
    ],
];
