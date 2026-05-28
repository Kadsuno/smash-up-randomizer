<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Services\TransactionalMailService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\View\View;

class ContactController extends Controller
{
    /**
     * Show the contact form and plant a server-side timing seed in the session.
     */
    public function index(): View
    {
        session(['contact_form_start' => now()->timestamp]);

        return view('contact.contactForm');
    }

    /**
     * Validate and store a contact form submission.
     */
    public function store(Request $request): RedirectResponse
    {
        // Honeypot: any bot that fills the hidden field is rejected immediately.
        if (! empty($request->input('context'))) {
            return redirect()->back()->with(['error' => 'Spam detected!']);
        }

        // Timing: reject submissions that arrive before the minimum human delay.
        $formStart = session('contact_form_start', 0);
        if (now()->timestamp - $formStart < 3) {
            return redirect()->back()->with(['error' => 'Spam detected!']);
        }

        $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email:rfc,dns',
            'phone'   => 'nullable|regex:/^[0-9\s\-()+]+$/',
            'subject' => 'required|in:Bug report,Missing faction,Feature request,General feedback,Other',
            'message' => 'required|string|min:20',
        ]);

        // Turnstile CAPTCHA verification.
        if (! $this->verifyTurnstile($request->input('cf-turnstile-response', ''))) {
            return redirect()->back()->with(['error' => 'Spam detected!']);
        }

        // Timing seed is consumed; renew it so re-submission after error works.
        session(['contact_form_start' => now()->timestamp]);

        $phone = $request->filled('phone') ? (string) $request->input('phone') : null;

        Contact::create([
            'name'    => (string) $request->input('name'),
            'email'   => (string) $request->input('email'),
            'phone'   => $phone,
            'subject' => (string) $request->input('subject'),
            'message' => (string) $request->input('message'),
        ]);

        $mailer = new TransactionalMailService;

        $mailPayload = [
            'name'    => (string) $request->input('name'),
            'email'   => (string) $request->input('email'),
            'phone'   => $phone,
            'subject' => (string) $request->input('subject'),
            'message' => (string) $request->input('message'),
        ];

        $mailer->send(
            $request->email,
            'Thank you for contacting Smash Up Randomizer',
            'Thank you for contacting Smash Up Randomizer. We will get back to you shortly.',
            'emails.confirmContact',
            $mailPayload
        );

        $adminPlain = 'New contact from Smash Up Randomizer. Name: '.$mailPayload['name']
            .' Email: '.$mailPayload['email']
            .' Phone: '.($mailPayload['phone'] ?? '—')
            .' Subject: '.$mailPayload['subject']
            .' Message: '.$mailPayload['message'];

        $mailer->send(
            (string) config('mail.admin_email', 'info@smash-up-randomizer.com'),
            'New contact from Smash Up Randomizer',
            $adminPlain,
            'emails.contact',
            $mailPayload
        );

        return redirect()->back()
            ->with(['success' => 'Thanks for reaching out! We\'ll get back to you within 1–2 business days.']);
    }

    /**
     * Verify a Cloudflare Turnstile token.
     *
     * Returns true when running in the test environment or when no secret key
     * is configured (local dev without Turnstile credentials).
     */
    private function verifyTurnstile(string $token): bool
    {
        if (app()->environment('testing')) {
            return true;
        }

        $secret = config('services.turnstile.secret');

        if (empty($secret)) {
            return true;
        }

        $response = Http::asForm()->post(
            'https://challenges.cloudflare.com/turnstile/v0/siteverify',
            [
                'secret'   => $secret,
                'response' => $token,
            ]
        );

        return (bool) $response->json('success', false);
    }
}
