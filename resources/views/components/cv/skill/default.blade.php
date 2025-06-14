@props([
    'textsize' => [],
    'bordercolor' => 'border-teal-500',
    'heading' => 'Kemampuan',
    'skills' => [],
])

<!-- Skills -->
<div class="space-y-2">
    <x-cv.heading :textsize="$textsize" :heading="$heading" :bordercolor="$bordercolor" />

    <ul class="grid grid-cols-2 list-disc ms-6 mt-3 space-y-1.5" style="font-size: {{ $textsize['base'] }}px;">
        @foreach ($skills as $skill)
            <li class="ps-1 text-gray-600">
                {{ $skill }}
            </li>
        @endforeach
    </ul>
</div>
<!-- End Skills -->
