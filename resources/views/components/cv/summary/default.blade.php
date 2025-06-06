@props([
    'bordercolor' => 'border-teal-500',
    'heading' => 'Tentang Saya',
    'summary' => '',
])

<!-- Summary -->
<div class="space-y-2">
    <x-cv.heading :heading="$heading" :bordercolor="$bordercolor" />

    <article class="prose prose-sm !text-sm max-w-none">
        {!! $summary !!}
    </article>
</div>
<!-- End Summary -->
