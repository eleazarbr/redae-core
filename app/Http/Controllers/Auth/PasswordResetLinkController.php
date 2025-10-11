<?php

namespace App\Http\Controllers\Auth;

use App\Actions\Auth\SendPasswordResetLink;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Support\Recaptcha;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class PasswordResetLinkController extends Controller
{
    /**
     * Show the password reset link request page.
     */
    public function create(Request $request): Response
    {
        return Inertia::render('auth/ForgotPassword', [
            'status' => $request->session()->get('status'),
            'recaptcha' => Recaptcha::configuration('forgot_password'),
        ]);
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(ForgotPasswordRequest $request, SendPasswordResetLink $sendPasswordResetLink): RedirectResponse
    {
        $validated = $request->validated();

        $sendPasswordResetLink
            ->onQueue('emails')
            ->execute($validated['email']);

        return back()->with('status', __('auth.forgot_password.reset_link_sent'));
    }
}
