@props([
    'bordercolor' => 'border-teal-500',
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
    <x-cv.heading :heading="$heading" :bordercolor="$bordercolor" />

    @foreach ($experiences as $experience)
        <div class="group">
            <div class="grow pb-2 group-last:pb-0 space-y-2">
                <div class="flex items-center justify-between">
                    <p class="font-semibold space-x-1">
                        <span>{{ $experience['position'] }}</span>
                        <span>|</span>
                        <span class="underline">{{ $experience['company'] }}</span>
                    </p>
                    <h3 class="text-gray-600">
                        {{ $month[$experience['start_month']] . ' ' . $experience['start_year'] . ' - ' . $month[$experience['end_month']] . ' ' . $experience['end_year'] }}
                    </h3>
                </div>

                @if (Arr::has($experience, 'description'))
                    <p class="text-sm text-gray-600">
                        {{ $experience['description'] }}
                    </p>
                @endif

                @if (Arr::has($experience, 'jobdesk'))
                    <ul class="list-disc ms-6 space-y-1.5">
                        @foreach ($experience['jobdesk'] as $job_desk)
                            <li class="ps-1 text-sm text-gray-600">
                                {{ $job_desk }}
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    @endforeach
</div>
<!-- End Experience -->
