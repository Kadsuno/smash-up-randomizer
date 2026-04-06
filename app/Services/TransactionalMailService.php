<?php

declare(strict_types=1);

namespace App\Services;

use Exception;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\View;

/**
 * Sends HTML/plain emails through Laravel's default mailer (SMTP, log, etc.).
 */
class TransactionalMailService
{
    /**
     * Send a transactional email with optional HTML body from a Blade view.
     *
     * @param  string  $to  Recipient address
     * @param  string  $subject  Email subject
     * @param  string  $plainText  Plain-text body (always included)
     * @param  string|null  $view  Blade view name for HTML body (e.g. emails.contact)
     * @param  array<string, mixed>  $data  Data passed to the view as $data (object)
     * @return bool True if the message was handed to the mailer without exception
     */
    public function send(
        string $to,
        string $subject,
        string $plainText,
        ?string $view = null,
        array $data = []
    ): bool {
        try {
            Mail::send([], [], function (Message $message) use ($to, $subject, $plainText, $view, $data): void {
                $message->to($to)
                    ->subject($subject)
                    ->from(
                        (string) config('mail.from.address'),
                        (string) config('mail.from.name')
                    );
                $message->text($plainText);
                if ($view !== null) {
                    $html = View::make($view, ['data' => (object) $data])->render();
                    $message->html($html);
                }
            });

            return true;
        } catch (Exception $e) {
            report($e);

            return false;
        }
    }
}
