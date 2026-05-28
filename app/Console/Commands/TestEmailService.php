<?php

namespace App\Console\Commands;

use App\Services\TransactionalMailService;
use Illuminate\Console\Command;
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
    protected $description = 'Test if the configured mailer (e.g. SMTP / Brevo) is working';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Testing transactional mail (default mailer)...');

        $mailer = new TransactionalMailService;
        $testEmail = config('mail.test_email', 'info@smash-up-randomizer.com');

        try {
            $ok = $mailer->send(
                $testEmail,
                'Automatic Email Test - Smash Up Randomizer',
                'This is an automatic test email to verify SMTP / mail configuration.',
                'emails.test',
                ['timestamp' => now()->format('Y-m-d H:i:s')]
            );

            if ($ok) {
                Log::info('Scheduled email test successful - Email sent to: '.$testEmail);
                $this->info('Email test successful! Sent to: '.$testEmail);

                return Command::SUCCESS;
            }

            Log::error('Scheduled email test failed - mailer returned false');
            $this->error('Email test failed: mailer returned false (check logs).');

            return Command::FAILURE;
        } catch (\Exception $e) {
            Log::error('Scheduled email test exception: '.$e->getMessage());
            $this->error('Email test exception: '.$e->getMessage());

            return Command::FAILURE;
        }
    }
}
