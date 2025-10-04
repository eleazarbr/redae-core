<?php

namespace App\Http\Controllers\Auth;

use Inertia\Inertia;
use Inertia\Response;
use App\Actions\Auth\RegisterUser;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Actions\Auth\SendVerificationEmail;
use App\Http\Requests\Auth\RegisterRequest;
use Illuminate\Validation\ValidationException;

class RegisteredUserController extends Controller
{
    /**
     * Show the registration page.
     */
    public function create(): Response
    {
        return Inertia::render('auth/Register');
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
