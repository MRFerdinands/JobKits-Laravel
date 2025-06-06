@props([
    'bordercolor' => 'border-teal-500',
    'heading' => 'Pendidikan',
    'educations' => [],
])

<!-- Education -->
<div class="space-y-2">
    <x-cv.heading :heading="$heading" :bordercolor="$bordercolor" />

    @foreach ($educations as $education)
        <div class="group">
            <div class="grow pb-2 group-last:pb-0 space-y-2">
                <div class="flex items-center justify-between">
                    <p class="font-semibold">
                        <span class="underline">{{ $education['institution'] }}</span>
                        <span>|</span>
                        <span>{{ $education['major'] }}</span>
                    </p>
                    <h3 class="text-gray-600">
                        {{ $education['start_year'] . ' - ' . $education['end_year'] }}
                    </h3>
                </div>

                @if (Arr::has($education, 'description'))
                    <p class="text-sm text-gray-600">
                        {{ $education['description'] }}
                    </p>
                @endif

                @if (Arr::has($education, 'study_info'))
                    <ul class="list-disc ms-6 space-y-1.5">
                        @foreach ($education['study_info'] as $ngapain)
                            <li class="ps-1 text-sm text-gray-600">
                                {{ $ngapain }}
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    @endforeach
</div>
<!-- End Education -->
