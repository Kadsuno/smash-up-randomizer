<?php

namespace App\Services;

use SendGrid;
use SendGrid\Mail\Mail;
use Exception;
use Illuminate\Support\Facades\View;

class SendGridMailService
{
    public function send($to, $subject, $plainText, $view = null, $data = [])
    {
        $email = new Mail();
        $email->setFrom("info@smash-up-randomizer.com", "Smash Up Randomizer");
        $email->setSubject($subject);
        $email->addTo($to);
        $email->addContent("text/plain", $plainText);

        if ($view) {
            $html = View::make($view, $data)->render();
            $email->addContent("text/html", $html);
        }

        $sendgrid = new SendGrid(config('services.sendgrid.api_key'));

        try {
            return $sendgrid->send($email);
        } catch (Exception $e) {
            report($e);
            return false;
        }
    }
}