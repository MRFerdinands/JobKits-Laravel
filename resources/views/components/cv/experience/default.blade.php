@props([
    'heading' => 'Pengalaman',
    'experiences' => [],
])

@php
    $month = [
        '01' => 'Januari',
        '02' => 'Februari',
        '03' => 'Maret',
        '04' => 'April',
        '05' => 'Mei',
        '06' => 'Juni',
        '07' => 'Juli',
        '08' => 'Agustus',
        '09' => 'September',
        '10' => 'Oktober',
        '11' => 'November',
        '12' => 'Desember',
    ];
@endphp

<!-- Experience -->
<div class="space-y-2">
    <x-cv.heading :heading="$heading" />

    <div>
        @foreach ($experiences as $experience)
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
                        {{ $month[$experience['start_month']] . ' ' . $experience['start_year'] . ' - ' . $month[$experience['end_month']] . ' ' . $experience['end_year'] }}
                    </h3>

                    <p class="font-semibold text-sm">
                        {{ $experience['position'] . ' | ' . $experience['company'] }}
                    </p>

                    @if (Arr::has($experience, 'description'))
                        <p class="mt-1 text-sm text-gray-600">
                            {{ $experience['description'] }}
                        </p>
                    @endif

                    @if (Arr::has($experience, 'jobdesk'))
                        <ul class="list-disc ms-6 mt-3 space-y-1.5">
                            @foreach ($experience['jobdesk'] as $job_desk)
                                <li class="ps-1 text-sm text-gray-600">
                                    {{ $job_desk }}
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
<!-- End Experience -->
