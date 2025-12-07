<?php

namespace Tests\Browser\Pages;

use Laravel\Dusk\Browser;

class RegisterPage extends Page
{
    public function url(): string
    {
        return route('register');
    }

    public function elements(): array
    {
        return [
            '@register-form' => '[dusk="register-form"]',
            '@company_name' => '[dusk="company_name"]',
            '@name' => '[dusk="name"]',
            '@last_name' => '[dusk="last_name"]',
            '@email' => '[dusk="email"]',
            '@password' => '[dusk="password"]',
            '@password_confirmation' => '[dusk="password_confirmation"]',
            '@terms_accepted' => '[dusk="terms_accepted"]',
            '@submit' => '[dusk="submit"]',
        ];
    }

    public function fillForm(Browser $browser, array $data): Browser
    {
        return $browser
            ->waitFor('@register-form')
            ->type('@company_name', $data['company_name'] ?? '')
            ->type('@name', $data['name'] ?? '')
            ->type('@last_name', $data['last_name'] ?? '')
            ->type('@email', $data['email'] ?? '')
            ->type('@password', $data['password'] ?? '')
            ->type('@password_confirmation', $data['password_confirmation'] ?? $data['password'] ?? '')
            ->check('@terms_accepted');
    }

    public function submit(Browser $browser): Browser
    {
        return $browser->press('@submit');
    }
}
