<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\SendgridMailService;
use Illuminate\Support\Facades\Log;

class TestEmailService extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test if the SendGrid API email service is working properly';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Testing SendGrid API email service...');

        $mailer = new SendgridMailService();
        $testEmail = config('mail.test_email', 'info@smash-up-randomizer.com');

        try {
            $response = $mailer->send(
                $testEmail,
                'Automatic Email Test - Smash Up Randomizer',
                'This is an automatic test email to verify SendGrid API functionality.',
                'emails.test',
                ['timestamp' => now()->format('Y-m-d H:i:s')]
            );

            // Check if email was sent successfully
            if ($response && $response->statusCode() == 202) {
                Log::info('Scheduled email test successful - Email sent to: ' . $testEmail);
                $this->info('Email test successful! Sent to: ' . $testEmail);
                return Command::SUCCESS;
            } else {
                $statusCode = $response ? $response->statusCode() : 'No response';
                Log::error('Scheduled email test failed - Status code: ' . $statusCode);
                $this->error('Email test failed! Status code: ' . $statusCode);
                return Command::FAILURE;
            }
        } catch (\Exception $e) {
            Log::error('Scheduled email test exception: ' . $e->getMessage());
            $this->error('Email test exception: ' . $e->getMessage());
            return Command::FAILURE;
        }
    }
}
