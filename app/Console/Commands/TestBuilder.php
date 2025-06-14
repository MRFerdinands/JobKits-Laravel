<?php

namespace App\Console\Commands;

use App\Builder\CVBuilder;
use Illuminate\Console\Command;

class TestBuilder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:builder';

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
        echo CVBuilder::make('Rio Ferdinand')
            ->picture(asset('ktpdummy.png'))
            ->toString();
    }
}
