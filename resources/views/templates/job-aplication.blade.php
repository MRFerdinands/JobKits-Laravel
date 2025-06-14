@extends('components.layouts.app')

@use('Carbon\Carbon')
@use('App\Helper\GlobalHelper')

@section('section')
    @if (in_array('cl', $download_opt ?? ['cl']))
        <div class="px-[3rem] py-[2.3rem] leading-relaxed" style="font-size: {{ $text_size['base'] }}px;">
            <div class="space-y-3">
                <div class="text-end">
                    <p class="font-medium">
                        {{ $data->address['regency'] . ', ' . now()->translatedFormat('d F Y') }}</p>
                </div>

                <div class="text-start font-medium">
                    <p>Perihal: Lamaran Kerja untuk Posisi {{ $data->position }}</p>
                    <p>Lampiran: {{ count($data->documents) }} berkas</p>
                </div>

                <div class="text-start font-medium">
                    <p>Kepada Yth,</p>
                    <p>{{ 'Bapak/Ibu Manager SDM ' . $data->company_name }}</p>
                    <p>Di tempat</p>
                </div>

                <div class="text-start">
                    <p class="text-start font-medium">Dengan hormat,</p>
                    <p>
                        Berdasarkan informasi dari {{ $data->from }} pada
                        {{ now()->translatedFormat('d F Y') }}, {{ $data->company_name }}
                        membuka
                        lowongan
                        pekerjaan untuk posisi {{ $data->position }}. Melalui surat lamaran ini, saya bermaksud melamar
                        posisi
                        tersebut di perusahaan yang Bapak/Ibu pimpin. Adapun data diri saya sebagai berikut:
                    </p>
                </div>

                <div class="text-start ms-5">
                    <div class="grid grid-cols-[auto_1fr] gap-x-2 gap-y-1">
                        <p class="font-medium">Nama Lengkap</p>
                        <p>: {{ $data->name }}</p>
                        <p class="font-medium">Tempat Tanggal Lahir</p>
                        <p>
                            <span>:</span>
                            {{ $data->birth_location . ', ' . Carbon::parse($data->date_of_birth)->translatedFormat('d F Y') }}
                        </p>
                        <p class="font-medium">Nomor Telepon</p>
                        <p><span>:</span> {{ $data->phone }}</p>
                        <p class="font-medium">Email</p>
                        <p><span>:</span> {{ $data->email }}</p>
                        <p class="font-medium">Pendidikan</p>
                        <p><span>:</span> {{ $data->educations[count($data->educations) - 1]['degree'] }}</p>
                        <p class="font-medium">Alamat Domisili</p>
                        <p><span>:</span> {{ GlobalHelper::formatAddress($data->address) }}</p>
                    </div>
                </div>

                <div class="text-start">
                    <p>
                        Surat Lamaran diatas saya buat dalam keadaan sehat, sebagai bahan pertimbangan
                        saya lampirkan beberapa berkas berikut ini :
                    </p>
                </div>

                <div class="text-start ms-5">
                    <ol class="ms-6 space-y-1.5">
                        @foreach ($data->documents as $key => $document)
                            <li class="ps-1 font-medium list-item">
                                {{ $key + 1 . '. ' . $document['name'] }}
                            </li>
                        @endforeach
                    </ol>
                </div>

                <div class="text-start space-y-3">
                    <p>
                        Besar harapan saya untuk bisa bergabung dan turut berkontribusi dalam memajukan perusahaan Anda.
                        Demikian surat lamaran kerja ini saya buat dengan sebenar-benarnya. Atas perhatian Bapak/Ibu, saya
                        ucapkan terima kasih.
                    </p>
                </div>

                <div class="flex justify-end mt-13 pe-5">
                    <div class="flex flex-col items-center">
                        <p class="font-medium">Hormat saya,</p>
                        <div>
                            <img class="w-40 h-24 object-cover" src="{{ $data->signature }}" alt="Tanda Tangan">
                        </div>
                        <p class="font-bold">({{ $data->name }})</p>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if (in_array('cv', $download_opt ?? ['cv']))
        <x-page-break />

        <div style="font-size: {{ $text_size['base'] }}px;">
            <div class="p-4 space-y-2">
                <x-cv.profile.with-picture :textsize="$text_size" :picture="$data->picture" :name="$data->name" :phone="$data->phone"
                    :email="$data->email" :birthloc="$data->birth_location" :dateofbirth="$data->date_of_birth" :address="$data->address" :bordercolor="$border_color" />

                <x-cv.summary.default :textsize="$text_size" heading="Tentang Saya" :summary="$data->summary" :bordercolor="$border_color" />

                @if (!empty($data->experiences))
                    <x-cv.experience.ats :textsize="$text_size" heading="Pengalaman" :experiences="$data->experiences" :bordercolor="$border_color" />
                @endif

                <x-cv.education.ats :textsize="$text_size" heading="Pendidikan" :educations="$data->educations" :bordercolor="$border_color" />

                <x-cv.skill.default :textsize="$text_size" heading="Kemampuan" :skills="$data->skills" :bordercolor="$border_color" />

                @if (!empty($data['extra_info']))
                    <x-cv.extra.default :textsize="$text_size" heading="Informasi Tambahan" :extrainfo="$data->extra_info"
                        :bordercolor="$border_color" />
                @endif
            </div>
        </div>
    @endif

    @if (in_array('doc', $download_opt ?? ['doc']))
        <x-page-break />

        <div class="h-screen">
            <div class="flex flex-col gap-5">
                <img class="w-[450px]" src="{{ asset('KTP.jpg') }}" alt="KTP">
                <img class="w-[200px]" src="{{ asset('FotoJas4x6.jpeg') }}" alt="Jas">
            </div>
        </div>
        @foreach ($data->documents as $document)
            @if ($document['type'] === 'soft')
                <div class="text-sm h-screen">
                    <img class="w-full h-full" src="{{ asset($document['file_path']) }}" alt="">
                </div>
            @endif
        @endforeach
    @endif
@endsection
