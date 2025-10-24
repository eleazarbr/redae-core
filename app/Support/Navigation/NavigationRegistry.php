<?php

namespace App\Support\Navigation;

use Illuminate\Support\Arr;

class NavigationRegistry
{
    /**
     * Registered navigation items grouped by area.
     *
     * @var array<string, mixed>
     */
    protected array $items = [];

    /**
     * Extend a navigation area with additional items.
     *
     * @param  array<int, array<string, mixed>>|\Closure(): array<int, array<string, mixed>>  $items
     */
    public function extend(string $area, array|\Closure $items): void
    {
        $resolved = value($items);

        if (! is_array($resolved)) {
            return;
        }

        $existing = Arr::get($this->items, $area, []);

        Arr::set($this->items, $area, array_values(array_merge($existing, $resolved)));
    }

    /**
     * Retrieve the items for a given navigation area.
     *
     * @return array<int, array<string, mixed>>
     */
    public function get(string $area): array
    {
        return Arr::get($this->items, $area, []);
    }

    /**
     * Return the entire navigation registry.
     *
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return $this->items;
    }
}
