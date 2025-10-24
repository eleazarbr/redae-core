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
                    'href' => route('dashboard', [], false),
                    'icon' => 'LayoutGrid',
                ],
                [
                    'title' => 'dashboard.sidebar.company',
                    'href' => route('company.index', [], false),
                    'icon' => 'Building2',
                ],
            ]);

            $navigation->extend('sidebar.footer', [
                [
                    'title' => 'dashboard.sidebar.github_repo',
                    'href' => 'https://github.com/eleazarbr/redae-core',
                    'icon' => 'Folder',
                ],
                [
                    'title' => 'dashboard.sidebar.documentation',
                    'href' => route('home', [], false),
                    'icon' => 'BookOpen',
                ],
            ]);

            $navigation->extend('company.tabs', [
                [
                    'title' => 'company.navbar.general',
                    'href' => route('company.index', [], false),
                ],
            ]);

            $navigation->extend('settings.tabs', [
                [
                    'title' => 'settings.navbar.profile',
                    'href' => route('profile.edit', [], false),
                ],
                [
                    'title' => 'settings.navbar.password',
                    'href' => route('password.edit', [], false),
                ],
                [
                    'title' => 'settings.navbar.appearance',
                    'href' => route('appearance', [], false),
                ],
            ]);
        });
    }
}
