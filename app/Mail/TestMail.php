<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TestMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct()
    {
    }

    public function build()
    {
        return $this->html('<h1>Test Email from FAISTROQUER</h1><p>This is a test email to verify that the email configuration is working correctly.</p>')
                    ->subject('Test Email from FAISTROQUER');
    }
} 