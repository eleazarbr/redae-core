<?php

namespace App\Enums\Company;

enum UserStatus: int
{
    case ACTIVE = 1;
    case INACTIVE = 0;
    case PENDING = 2;
    case SUSPENDED = 3;

    /**
     * Get all enum values as an array.
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    /**
     * Get the enum label for display purposes.
     */
    public function label(): string
    {
        return match ($this) {
            self::ACTIVE => 'Active',
            self::INACTIVE => 'Inactive',
            self::PENDING => 'Pending',
            self::SUSPENDED => 'Suspended',
        };
    }

    /**
     * Check if the status is active.
     */
    public function isActive(): bool
    {
        return $this === self::ACTIVE;
    }
}
