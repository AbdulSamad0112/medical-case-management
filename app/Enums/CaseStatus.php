<?php

namespace App\Enums;

enum CaseStatus: string
{
    case DRAFT = 'Draft';
    case PLANNING = 'Planning';
    case IN_REVIEW = 'In Review';
    case APPROVED = 'Approved';
    case COMPLETED = 'Completed';
    case CANCELLED = 'Cancelled';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public function badgeClasses(): string
    {
        return match ($this) {
            self::DRAFT => 'bg-slate-100 text-slate-700 border-slate-300',
            self::PLANNING => 'bg-sky-50 text-sky-700 border-sky-300',
            self::IN_REVIEW => 'bg-amber-50 text-amber-700 border-amber-300',
            self::APPROVED => 'bg-emerald-50 text-emerald-700 border-emerald-300',
            self::COMPLETED => 'bg-teal-50 text-teal-800 border-teal-300',
            self::CANCELLED => 'bg-rose-50 text-rose-700 border-rose-300',
        };
    }
}
