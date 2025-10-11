<?php

namespace App\Http\Controllers\Auth;

use App\Actions\Auth\RegisterUser;
use App\Actions\Auth\SendVerificationEmail;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Support\Recaptcha;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;

class RegisteredUserController extends Controller
{
    /**
     * Show the registration page.
     */
    public function create(): Response
    {
        return Inertia::render('auth/Register', [
            'recaptcha' => Recaptcha::configuration('register'),
        ]);
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(RegisterRequest $request, RegisterUser $register, SendVerificationEmail $sendVerification): RedirectResponse
    {
        $user = $register->execute($request->validated());

        $sendVerification->onQueue('emails')->execute($user);

        Auth::login($user);

        return to_route('dashboard');
    }
}
