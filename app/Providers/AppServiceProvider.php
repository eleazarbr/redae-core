<?php

namespace App\Providers;

use App\Http\Controllers\WelcomeController;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        VerifyEmail::toMailUsing(function ($_, string $verificationUrl) {
            return (new MailMessage)
                ->greeting(Lang::get('auth.notifications.greeting'))
                ->subject(Lang::get('auth.notifications.verify_email.subject'))
                ->line(Lang::get('auth.notifications.verify_email.line_1'))
                ->action(Lang::get('auth.notifications.verify_email.action'), $verificationUrl)
                ->salutation(Lang::get('auth.notifications.salutation'))
                ->line(Lang::get('auth.notifications.verify_email.line_2'));
        });

        ResetPassword::toMailUsing(function ($notifiable, string $token) {
            $resetUrl = url(route('password.reset', [
                'token' => $token,
                'email' => $notifiable->getEmailForPasswordReset(),
            ], false));

            return (new MailMessage)
                ->greeting(Lang::get('auth.notifications.greeting'))
                ->subject(Lang::get('auth.notifications.reset_password.subject'))
                ->line(Lang::get('auth.notifications.reset_password.line_1'))
                ->action(Lang::get('auth.notifications.reset_password.action'), $resetUrl)
                ->line(Lang::get('auth.notifications.reset_password.line_2', [
                    'count' => config('auth.passwords.'.config('auth.defaults.passwords').'.expire'),
                ]))
                ->salutation(Lang::get('auth.notifications.salutation'))
                ->line(Lang::get('auth.notifications.reset_password.line_3'));
        });

        $this->app->booted(function () {
            if (Route::has('home')) {
                return;
            }

            Route::middleware('web')->group(function () {
                Route::get('/', [WelcomeController::class, 'index'])->name('home');
            });
        });
    }
}
