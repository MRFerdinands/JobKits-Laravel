<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\LaravelPdf\Facades\Pdf;

class TestPDF extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:pdf';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Pdf::view('templates.ats')
            ->disk('public')
            ->save('cv-ats.pdf');

        Pdf::view('templates.cover-letter')
            ->disk('public')
            ->save('cover-letter.pdf');
    }
}
