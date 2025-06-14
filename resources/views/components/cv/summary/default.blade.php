@props([
    'textsize' => [],
    'bordercolor' => 'border-teal-500',
    'heading' => 'Tentang Saya',
    'summary' => '',
])

<!-- Summary -->
<div class="space-y-2">
    <x-cv.heading :textsize="$textsize" :heading="$heading" :bordercolor="$bordercolor" />

    <article class="prose prose-sm max-w-none" style="font-size: {{ $textsize['base'] }}px;">
        {!! $summary !!}
    </article>
</div>
<!-- End Summary -->
