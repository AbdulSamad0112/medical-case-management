<?php

namespace App\Enums;

enum CasePriority: string
{
    case LOW = 'Low';
    case MEDIUM = 'Medium';
    case HIGH = 'High';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public function badgeClasses(): string
    {
        return match ($this) {
            self::LOW => 'bg-slate-100 text-slate-700 border-slate-200',
            self::MEDIUM => 'bg-amber-100 text-amber-800 border-amber-200',
            self::HIGH => 'bg-red-100 text-red-800 border-red-200',
        };
    }
}
