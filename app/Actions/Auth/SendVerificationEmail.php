<?php

namespace App\Actions\Auth;

use App\Models\User;
use Spatie\QueueableAction\QueueableAction;

final class SendVerificationEmail
{
    use QueueableAction;

    public array|int $backoff = [10, 60, 300];

    public function tags(): array
    {
        return [
            'action',
            'email',
            'verification',
        ];
    }

    /**
     * Execute the action.
     */
    public function execute(User $user): void
    {
        $user->sendEmailVerificationNotification();
    }
}
