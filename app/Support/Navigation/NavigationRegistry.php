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
        return $this->resolveValue($this->items);
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

            return array_is_list($value)
                ? $this->sortNavigationList($value)
                : $value;
        }

        return $value;
    }

    /**
     * Sort a navigation list based on the optional "order" property.
     *
     * Items without an explicit order retain their relative position and are
     * placed after all ordered items.
     *
     * @param  array<int, mixed>  $items
     * @return array<int, mixed>
     */
    protected function sortNavigationList(array $items): array
    {
        $indexed = [];

        foreach ($items as $index => $item) {
            $indexed[] = [
                'item' => $item,
                'order' => is_array($item) && array_key_exists('order', $item)
                    ? $item['order']
                    : null,
                'index' => $index,
            ];
        }

        usort($indexed, function (array $a, array $b): int {
            $aOrder = $a['order'];
            $bOrder = $b['order'];

            if ($aOrder === $bOrder) {
                return $a['index'] <=> $b['index'];
            }

            if ($aOrder === null) {
                return 1;
            }

            if ($bOrder === null) {
                return -1;
            }

            return $aOrder <=> $bOrder;
        });

        return array_map(static fn (array $entry) => $entry['item'], $indexed);
    }
}
