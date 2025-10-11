<?php

namespace App\Enums\Company;

enum UserRole: int
{
    case OWNER = 0;
    case ADMIN = 1;
    case MEMBER = 2;
    case VIEWER = 3;

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
            self::OWNER => 'Owner',
            self::ADMIN => 'Administrator',
            self::MEMBER => 'Member',
            self::VIEWER => 'Viewer',
        };
    }
}
