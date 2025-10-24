<?php

namespace App\Support\Navigation;

use Closure;
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
    public function extend(string $area, array|Closure $items): void
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
        $items = Arr::get($this->items, $area, []);

        return is_array($items) ? $this->resolveValue($items) : [];
    }

    /**
     * Return the entire navigation registry.
     *
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        /** @var array<string, mixed> $resolved */
        $resolved = $this->resolveValue($this->items);

        return $resolved;
    }

    /**
     * Resolve any deferred values stored in the navigation tree.
     */
    protected function resolveValue(mixed $value): mixed
    {
        if ($value instanceof Closure) {
            return $this->resolveValue(value($value));
        }

        if (is_array($value)) {
            foreach ($value as $key => $nested) {
                $value[$key] = $this->resolveValue($nested);
            }

            return $value;
        }

        return $value;
    }
}
