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
            '@name' => '[dusk="name"]',
            '@email' => '[dusk="email"]',
            '@password' => '[dusk="password"]',
            '@password_confirmation' => '[dusk="password_confirmation"]',
            '@submit' => '[dusk="submit"]',
        ];
    }

    public function fillForm(Browser $browser, array $data): Browser
    {
        return $browser
            ->waitFor('@register-form')
            ->type('@name', $data['name'] ?? '')
            ->type('@email', $data['email'] ?? '')
            ->type('@password', $data['password'] ?? '')
            ->type('@password_confirmation', $data['password_confirmation'] ?? $data['password'] ?? '');
    }

    public function submit(Browser $browser): Browser
    {
        return $browser->press('@submit');
    }
}
