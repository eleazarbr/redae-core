<?php

namespace Tests\Browser\Pages;

use Laravel\Dusk\Browser;

class LoginPage extends Page
{
    public function url(): string
    {
        return route('login');
    }

    public function elements(): array
    {
        return [
            '@login-status-message' => '[dusk="login-status-message"]',
            '@login-form' => '[dusk="login-form"]',
            '@email-label' => '[dusk="email-label"]',
            '@email-input' => '[dusk="email-input"]',
            '@email-error' => '[dusk="email-error"]',
            '@password-label' => '[dusk="password-label"]',
            '@password-input' => '[dusk="password-input"]',
            '@password-error' => '[dusk="password-error"]',
            '@forgot-password-link' => '[dusk="forgot-password-link"]',
            '@remember-label' => '[dusk="remember-label"]',
            '@remember-checkbox' => '[dusk="remember-checkbox"]',
            '@login-submit-button' => '[dusk="login-submit-button"]',
            '@login-spinner' => '[dusk="login-spinner"]',
            '@register-prompt' => '[dusk="register-prompt"]',
            '@register-link' => '[dusk="register-link"]',
        ];
    }

    public function fillForm(Browser $browser, array $data): Browser
    {
        return $browser
            ->waitFor('@login-form')
            ->type('@email', $data['email'] ?? '')
            ->type('@password', $data['password'] ?? '');
    }

    public function submit(Browser $browser): Browser
    {
        return $browser->press('@login-submit-button');
    }
}
