@props(['status'])

@php
    $statusValue = $status instanceof \BackedEnum ? $status->value : $status;
    $statusEnum = $status instanceof \App\Enums\CaseStatus ? $status : \App\Enums\CaseStatus::tryFrom($statusValue);
    $classes = $statusEnum ? $statusEnum->badgeClasses() : 'bg-slate-100 text-slate-700 border-slate-300';
@endphp

<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border {{ $classes }}">
    {{ $statusValue }}
</span>
