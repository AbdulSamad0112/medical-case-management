@props(['priority'])

@php
    $priorityValue = $priority instanceof \BackedEnum ? $priority->value : $priority;
    $priorityEnum = $priority instanceof \App\Enums\CasePriority ? $priority : \App\Enums\CasePriority::tryFrom($priorityValue);
    $classes = $priorityEnum ? $priorityEnum->badgeClasses() : 'bg-slate-100 text-slate-700 border-slate-200';
@endphp

<span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-semibold border {{ $classes }}">
    {{ $priorityValue }}
</span>
