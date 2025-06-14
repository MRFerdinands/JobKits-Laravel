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
<div class="flex flex-col items-center gap-1" style="font-size: {{ $textsize['base'] }}px;">
    <p class="font-bold" style="font-size: {{ $textsize['name_text'] }}px;">
        {{ $name }}
    </p>
    <p class="text-gray-900">Nomor Telepon <span>:</span> {{ $phone }}</p>
    <p class="text-gray-900">Email <span>:</span> {{ $email }}</p>
    <p class="text-gray-900">Tempat Tanggal Lahir <span>:</span>
        {{ $birthloc . ', ' . Carbon::parse($dateofbirth)->translatedFormat('d F Y') }}</p>
    <p class="text-gray-900">Alamat <span>:</span> {{ GlobalHelper::formatAddress($address) }}</p>
</div>
<!-- End Profile -->
