<?php

namespace App\Console\Commands;

use App\Mail\WelcomeEmail;
use Illuminate\Console\Command;
use App\Services\DynamicMailService;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Config;

class TestMail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:mail';

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
        try {
            $sender_name = "Rio Ferdinand";
            // $sender_name = "N o n z e";
            $sender_email = "mrioferdinand68@gmail.com";
            // $sender_email = "djdjdjjdjdsbsbhchxh@gmail.com";
            $sender_pass = "zoxd xcvs izcb npns"; // mrioferdinand68@gmail.com
            // $sender_pass = "mcmu wabl zqft mcht"; // djdjdjjdjdsbsbhchxh@gmail.com
            $send_to = "rioqwerty120@gmail.com";

            DynamicMailService::sendWithUserCredentials(
                $sender_email,
                $sender_pass,
                $sender_name,
                $send_to,
                new WelcomeEmail()
            );

            $this->info("Email sent successfully from: {$sender_name} ({$sender_email})");
            return Command::SUCCESS;
        } catch (\Exception $e) {
            $this->error('Failed to send email: ' . $e->getMessage());
            return Command::FAILURE;
        }
    }

    private function dynamicConfigExample()
    {
        // Temporarily override mail configuration
        Config::set([
            'mail.mailers.smtp.username' => 'user@example.com',
            'mail.mailers.smtp.password' => 'user-password',
            'mail.from.address' => 'user@example.com',
            'mail.from.name' => 'Dynamic User',
        ]);

        Mail::to('rioqwerty120@gmail.com')->send(new WelcomeEmail());
        $this->info('Email sent with runtime config override');
    }
}
