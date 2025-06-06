@props([
    'heading' => 'Pendidikan',
    'educations' => [],
])

<!-- Education -->
<div class="space-y-2">
    <x-cv.heading :heading="$heading" />

    <div>
        @foreach ($educations as $education)
            <!-- Item -->
            <div class="group relative flex gap-x-5">
                <!-- Icon -->
                <div
                    class="relative group-last:after:hidden after:absolute after:top-8 after:bottom-2 after:start-3 after:w-px after:-translate-x-[0.5px] after:bg-gray-200">
                    <div class="relative z-10 size-6 flex justify-center items-center">
                        <p class="text-2xl">•</p>
                    </div>
                </div>
                <!-- End Icon -->

                <!-- Right Content -->
                <div class="grow pb-3 group-last:pb-0">
                    <h3 class="mb-1 text-xs text-gray-600">
                        {{ $education['start_year'] . ' - ' . $education['end_year'] }}
                    </h3>

                    <p class="font-semibold text-sm">
                        {{ $education['institution'] . ' | ' . $education['major'] }}
                    </p>

                    @if (Arr::has($education, 'description'))
                        <p class="mt-1 text-sm text-gray-600">
                            {{ $education['description'] }}
                        </p>
                    @endif

                    @if (Arr::has($education, 'study_info'))
                        <ul class="list-disc ms-6 mt-3 space-y-1.5">
                            @foreach ($education['study_info'] as $ngapain)
                                <li class="ps-1 text-sm text-gray-600">
                                    {{ $ngapain }}
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
                <!-- End Right Content -->
            </div>
            <!-- End Item -->
        @endforeach
    </div>
</div>
<!-- End Education -->
