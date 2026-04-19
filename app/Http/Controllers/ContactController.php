<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Services\TransactionalMailService;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function index()
    {
        return view('contact.contactForm');
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'nullable|regex:/^[0-9\s\-()+]+$/',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        if (! empty($request->context)) {
            return redirect()->back()->with(['error' => 'Spam detected!']);
        }

        $startTime = $request->input('start_time');
        if (time() - $startTime < 3) {
            return redirect()->back()->with(['error' => 'Spam detected!']);
        }

        $phone = $request->filled('phone') ? (string) $request->input('phone') : null;

        Contact::create([
            'name' => (string) $request->input('name'),
            'email' => (string) $request->input('email'),
            'phone' => $phone,
            'subject' => (string) $request->input('subject'),
            'message' => (string) $request->input('message'),
        ]);

        $mailer = new TransactionalMailService;

        $mailPayload = [
            'name' => (string) $request->input('name'),
            'email' => (string) $request->input('email'),
            'phone' => $phone,
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
}
