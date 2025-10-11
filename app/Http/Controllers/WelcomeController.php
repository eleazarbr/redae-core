<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;

class WelcomeController extends Controller
{
    /**
     * Display the welcome page.
     */
    public function index(): RedirectResponse
    {
        return to_route('login');
    }
}
