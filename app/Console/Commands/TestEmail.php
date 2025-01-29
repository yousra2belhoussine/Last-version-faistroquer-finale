<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class TestEmail extends Command
{
    protected $signature = 'mail:test';
    protected $description = 'Test email configuration by sending a test email';

    public function handle()
    {
        $this->info('Testing email configuration...');

        try {
            $this->info('Mail configuration:');
            $this->info('MAIL_MAILER: ' . config('mail.default'));
            $this->info('MAIL_HOST: ' . config('mail.mailers.smtp.host'));
            $this->info('MAIL_PORT: ' . config('mail.mailers.smtp.port'));
            $this->info('MAIL_USERNAME: ' . config('mail.mailers.smtp.username'));
            $this->info('MAIL_ENCRYPTION: ' . config('mail.mailers.smtp.encryption'));
            $this->info('MAIL_FROM_ADDRESS: ' . config('mail.from.address'));
            $this->info('MAIL_FROM_NAME: ' . config('mail.from.name'));

            // Using raw mail functionality
            Mail::raw('Test email from FAISTROQUER', function($message) {
                $message->from(config('mail.from.address'), config('mail.from.name'))
                    ->to('test@example.com')
                    ->subject('Test Email');
            });

            $this->info('Test email sent successfully! Check your Mailtrap inbox.');
            return 0;
        } catch (\Exception $e) {
            $this->error('Failed to send test email:');
            $this->error($e->getMessage());
            Log::error('Mail test failed: ' . $e->getMessage());
            Log::error($e->getTraceAsString());
            return 1;
        }
    }
} 