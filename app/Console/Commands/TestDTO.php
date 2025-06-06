<?php

namespace App\Console\Commands;

use App\Dto\EducationDTO;
use Illuminate\Console\Command;
use Spatie\LaravelPdf\Facades\Pdf;

class TestDTO extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:dto';

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
        $institusi = "SMK KRIAN 1";
        $jurusan = 'RPL';

        $save = new EducationDTO($institusi, $jurusan);

        Pdf::view('templates.tes-dto', ['data' => $save])
            ->disk('public')
            ->save('cv-ats.pdf');
    }
}
