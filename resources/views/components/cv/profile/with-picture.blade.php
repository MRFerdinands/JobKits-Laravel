@props([
    'bordercolor' => 'border-teal-500',
    'picture' => '',
    'name' => '',
    'phone' => '',
    'email' => '',
    'birthloc' => '',
    'dateofbirth' => '',
    'address' => [],
])

@use('App\Helper\GlobalHelper')
@use('Carbon\Carbon')

<!-- Profile -->
<div class="flex gap-5">
    <img class="object-square size-32 rounded-lg border-2 {{ $bordercolor }}" src="{{ asset($picture) }}" alt="Picture">

    <div class="flex flex-col gap-2">
        <p class="font-bold text-2xl">
            {{ $name }}
        </p>
        <div class="grid grid-cols-[auto_1fr] gap-x-2 gap-y-1 text-sm text-gray-600">
            <p class="text-gray-900">Nomor Telepon</p>
            <p><span>:</span> {{ $phone }}</p>
            <p class="text-gray-900">Email</p>
            <p><span>:</span> {{ $email }}</p>
            <p class="text-gray-900">Tempat Tanggal Lahir</p>
            <p>
                <span>:</span> {{ $birthloc . ', ' . Carbon::parse($dateofbirth)->translatedFormat('d F Y') }}
            </p>
            <p class="text-gray-900">Alamat</p>
            <p><span>:</span> {{ GlobalHelper::formatAddress($address) }}</p>
        </div>
    </div>
</div>
<!-- End Profile -->
