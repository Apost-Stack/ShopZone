@props(['type' => 'info', 'message' => null])

@php
    $colors = [
        'success' => 'bg-green-100 text-green-800 border-green-300',
        'error' => 'bg-red-100 text-red-800 border-red-300',
        'info' => 'bg-blue-100 text-blue-800 border-blue-300',
        'warning' => 'bg-yellow-100 text-yellow-800 border-yellow-300',
    ];
@endphp

<div {{ $attributes->merge(['class' => 'mb-4 border rounded-lg p-3 '.$colors[$type] ?? $colors['info']]) }}>
    {{ $message ?? $slot }}
</div>
