@props([
    'textsize' => [],
    'bordercolor' => 'border-teal-500',
    'heading' => 'Extra Informasi',
    'extrainfo' => [],
])

<!-- Extra Field -->
<div class="space-y-2">
    <x-cv.heading :textsize="$textsize" :heading="$heading" :bordercolor="$bordercolor" />

    <div class="grid grid-cols-[auto_1fr] gap-x-2 gap-y-1 text-gray-600" style="font-size: {{ $textsize['base'] }}px;">
        @foreach ($extrainfo as $extra_field)
            <p class="text-gray-900">{{ $extra_field['name'] }}</p>
            <p><span>:</span> {{ $extra_field['value'] }}</p>
        @endforeach
    </div>
</div>
<!-- End Extra Field -->
