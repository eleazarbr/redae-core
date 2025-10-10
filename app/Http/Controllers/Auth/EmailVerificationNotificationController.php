<?php

namespace App\Http\Controllers\Auth;

use App\Actions\Auth\SendVerificationEmail;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class EmailVerificationNotificationController extends Controller
{
    /**
     * Send a new email verification notification.
     */
    public function store(Request $request, SendVerificationEmail $sendVerification): RedirectResponse
    {
        $user = $request->user();

        if ($user->hasVerifiedEmail()) {
            return redirect()->intended(route('dashboard', absolute: false));
        }

        $sendVerification->onQueue('emails')->execute($user);

        return back()->with('status', 'verification-link-sent');
    }
}
