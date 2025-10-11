<?php

namespace App\Actions\Auth;

use Illuminate\Support\Facades\Password;
use Spatie\QueueableAction\QueueableAction;

final class SendPasswordResetLink
{
    use QueueableAction;

    public array|int $backoff = [10, 60, 300];

    public function tags(): array
    {
        return [
            'action',
            'email',
            'password-reset',
        ];
    }

    /**
     * Execute the action.
     */
    public function execute(string $email): void
    {
        Password::sendResetLink([
            'email' => $email,
        ]);
    }
}
