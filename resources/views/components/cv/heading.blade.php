@props([
    'textsize' => [],
    'heading' => '',
    'bordercolor' => 'border-teal-500',
])

<h1 class="font-bold text-md border-b-2 {{ $bordercolor }}" style="font-size: {{ $textsize['heading'] }}px;">
    {{ $heading }}</h1>
