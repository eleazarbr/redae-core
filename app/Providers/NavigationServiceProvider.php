<?php

namespace App\Providers;

use App\Support\Navigation\NavigationRegistry;
use Illuminate\Support\ServiceProvider;

class NavigationServiceProvider extends ServiceProvider
{
    /**
     * Register bindings.
     */
    public function register(): void
    {
        $this->app->singleton(NavigationRegistry::class);
    }

    /**
     * Bootstrap navigation definitions.
     */
    public function boot(NavigationRegistry $navigation): void
    {
        $this->app->booted(function () use ($navigation) {
            $navigation->extend('sidebar.main', [
                [
                    'title' => 'dashboard.sidebar.dashboard',
                    'href' => fn () => route('dashboard', [], false),
                    'icon' => 'LayoutGrid',
                    'order' => 10,
                ],
                [
                    'title' => 'dashboard.sidebar.company',
                    'href' => fn () => route('company.index', [], false),
                    'icon' => 'Building2',
                    'order' => 20,
                ],
            ]);

            $navigation->extend('sidebar.footer', [
                [
                    'title' => 'dashboard.sidebar.github_repo',
                    'href' => 'https://github.com/eleazarbr/redae-core',
                    'icon' => 'Folder',
                    'order' => 90,
                ],
                [
                    'title' => 'dashboard.sidebar.documentation',
                    'href' => fn () => route('home', [], false),
                    'icon' => 'BookOpen',
                    'order' => 100,
                ],
            ]);

            $navigation->extend('company.tabs', [
                [
                    'title' => 'company.navbar.general',
                    'href' => fn () => route('company.index', [], false),
                    'order' => 10,
                ],
            ]);

            $navigation->extend('settings.tabs', [
                [
                    'title' => 'settings.navbar.profile',
                    'href' => fn () => route('profile.edit', [], false),
                    'order' => 10,
                ],
                [
                    'title' => 'settings.navbar.password',
                    'href' => fn () => route('password.edit', [], false),
                    'order' => 20,
                ],
                [
                    'title' => 'settings.navbar.appearance',
                    'href' => fn () => route('appearance', [], false),
                    'order' => 30,
                ],
            ]);
        });
    }
}
