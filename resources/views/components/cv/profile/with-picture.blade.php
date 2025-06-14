@props([
    'textsize' => [],
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
<div class="flex gap-3">
    <img class="object-square size-25 rounded-lg border-2 {{ $bordercolor }}" src="{{ asset($picture) }}" alt="Picture">

    <div class="flex flex-col gap-1">
        <p class="font-bold" style="font-size: {{ $textsize['name_text'] }}px;">
            {{ $name }}
        </p>
        <div class="grid grid-cols-[auto_1fr] gap-x-2 gap-y-1 text-gray-600"
            style="font-size: {{ $textsize['base'] }}px;">
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
