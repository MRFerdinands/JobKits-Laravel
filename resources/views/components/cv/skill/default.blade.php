@props([
    'bordercolor' => 'border-teal-500',
    'heading' => 'Kemampuan',
    'skills' => [],
])

<!-- Skills -->
<div class="space-y-2">
    <x-cv.heading :heading="$heading" :bordercolor="$bordercolor" />

    <ul class="grid grid-cols-2 list-disc ms-6 mt-3 space-y-1.5">
        @foreach ($skills as $skill)
            <li class="ps-1 text-sm text-gray-600">
                {{ $skill }}
            </li>
        @endforeach
    </ul>
</div>
<!-- End Skills -->
