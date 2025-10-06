<?php

namespace App\Http\Controllers;

use App\Actions\StaticPage\GetContentAction;
use Inertia\Inertia;

class StaticPageController extends Controller
{
    /**
     * Display the terms of service page.
     */
    public function terms(GetContentAction $getContent)
    {
        $page = $getContent->execute('terms');

        return Inertia::render('static/Terms', [
            'content' => $page['content'],
            'lastUpdated' => $page['lastUpdated'],
        ]);
    }

    /**
     * Display the privacy policy page.
     */
    public function privacy(GetContentAction $getContent)
    {
        $page = $getContent->execute('privacy');

        return Inertia::render('static/Privacy', [
            'content' => $page['content'],
            'lastUpdated' => $page['lastUpdated'],
        ]);
    }
}
