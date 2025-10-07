<?php

namespace App\Actions\StaticPage;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

final class GetContentAction
{
    /**
     * Execute the action.
     */
    public function execute(string $page): array
    {
        $locale = app()->getLocale();
        $filePath = resource_path("content/{$locale}/{$page}.md");
        $cacheKey = "static_page_{$locale}_{$page}";

        $content = Cache::remember($cacheKey, now()->addHours(24), function () use ($filePath) {
            if (! File::exists($filePath)) {
                return '<p>Content not found.</p>';
            }

            return Str::of(File::get($filePath))->markdown();
        });

        $lastUpdated = File::exists($filePath)
            ? date('F j, Y', File::lastModified($filePath))
            : null;

        return [
            'content' => $content,
            'lastUpdated' => $lastUpdated,
        ];
    }
}
