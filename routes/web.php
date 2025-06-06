<?php

use App\Dto\EducationDTO;
use App\Livewire\ATSTemplate;
use App\Models\JobApplication;
use Spatie\LaravelPdf\Enums\Unit;
use Spatie\LaravelPdf\Facades\Pdf;
use Illuminate\Support\Facades\Route;
use function Spatie\LaravelPdf\Support\pdf;

Route::get('/template-ats', function () {
    return pdf()
        ->view('templates.ats')
        ->name('cv-ats.pdf');
});

Route::get('/template-cover-letter', function () {
    return pdf()
        ->view('templates.cover-letter')
        ->name('cover-letter.pdf');
});

Route::get('/job-applications/view-pdf/{id}', function ($id) {
    $application = JobApplication::find($id);

    return pdf()
        ->view('templates.job-aplication', ['data' => $application, 'border_color' => ''])
        ->margins('20', '20', '20', '20', Unit::Pixel)
        ->name('cover-letter.pdf');
});

Route::get('/tespg', function () {
    $institusi = "SMK KRIAN 1";
    $jurusan = 'RPL';

    $save = new EducationDTO($institusi, $jurusan);

    return pdf()
        ->view('templates.tes-dto', ['data' => $save])
        ->name('cover-letter.pdf');
});
