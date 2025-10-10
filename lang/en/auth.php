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
    'verify_email' => [
        'title' => 'Verify email',
        'description' => 'Please verify your email address by clicking on the link we just emailed to you.',
        'head_title' => 'Email verification',
        'link_sent' => 'A new verification link has been sent to the email address you provided during registration.',
        'submit' => 'Resend verification email',
        'logout' => 'Log out',
    ],
    'notifications' => [
        'greeting' => 'Hello!',
        'verify_email' => [
            'subject' => 'Verify Email Address',
            'line_1' => 'Please click the button below to verify your email address.',
            'action' => 'Verify Email Address',
            'line_2' => 'If you did not create an account, no further action is required.',
        ],
        'reset_password' => [
            'subject' => 'Reset Password Notification',
            'line_1' => 'You are receiving this email because we received a password reset request for your account.',
            'action' => 'Reset Password',
            'line_2' => 'This password reset link will expire in :count minutes.',
            'line_3' => 'If you did not request a password reset, no further action is required.',
        ],
    ],
];
