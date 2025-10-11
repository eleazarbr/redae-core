<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    /**
     * Display the dashboard view.
     */
    public function index(): Response
    {
        return Inertia::render('Dashboard');
    }
}
