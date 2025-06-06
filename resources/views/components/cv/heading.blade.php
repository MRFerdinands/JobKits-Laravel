@props([
    'heading' => '',
    'bordercolor' => 'border-teal-500',
])

<h1 class="font-bold text-md border-b-2 {{ $bordercolor }}">{{ $heading }}</h1>
