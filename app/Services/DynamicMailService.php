<?php

namespace App\Services;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Config;

class DynamicMailService
{
    public static function sendWithUserCredentials($userEmail, $userPassword, $userName, $toEmail, $mailable)
    {
        // Create a unique mailer name for this user
        $mailerName = 'user_' . md5($userEmail);

        // Set up the mail configuration for this user
        Config::set("mail.mailers.{$mailerName}", [
            'transport' => 'smtp',
            'host' => 'smtp.gmail.com', // or get from user settings
            'port' => 587,
            'encryption' => 'tls',
            'username' => $userEmail,
            'password' => $userPassword,
            'timeout' => null,
        ]);

        // Update the from address for this mailer
        Config::set("mail.from", [
            'address' => $userEmail,
            'name' => $userName,
        ]);

        // Send the email using the custom mailer
        Mail::mailer($mailerName)->to($toEmail)->send($mailable);
    }
}
