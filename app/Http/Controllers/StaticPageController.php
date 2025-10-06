<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class StaticPageController extends Controller
{
    /**
     * Display the terms of service page.
     */
    public function terms()
    {
        return Inertia::render('static/Terms');
    }

    /**
     * Display the privacy policy page.
     */
    public function privacy()
    {
        return Inertia::render('static/Privacy');
    }
}
