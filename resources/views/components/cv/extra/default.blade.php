@props([
    'bordercolor' => 'border-teal-500',
    'heading' => 'Extra Informasi',
    'extrainfo' => [],
])

<!-- Extra Field -->
<div class="space-y-2">
    <x-cv.heading :heading="$heading" :bordercolor="$bordercolor" />

    <div class="grid grid-cols-[auto_1fr] gap-x-2 gap-y-1 text-sm text-gray-600">
        @foreach ($extrainfo as $extra_field)
            <p class="text-gray-900">{{ $extra_field['name'] }}</p>
            <p><span>:</span> {{ $extra_field['value'] }}</p>
        @endforeach
    </div>
</div>
<!-- End Extra Field -->
