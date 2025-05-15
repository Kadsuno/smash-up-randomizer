<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use App\Services\SendgridMailService;

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
            'phone' => 'required|regex:/^[0-9\s\-()+]+$/',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        if (!empty($request->context)) {
            return redirect()->back()->with(['error' => 'Spam detected!']);
        }

        $startTime = $request->input('start_time');
        if (time() - $startTime < 3) {
            return redirect()->back()->with(['error' => 'Spam detected!']);
        }

        Contact::create($request->all());

        $mailer = new SendgridMailService();

        $response = $mailer->send(
            $request->email,
            'Thank you for contacting Smash Up Randomizer',
            'Thank you for contacting Smash Up Randomizer. We will get back to you shortly.',
            'emails.confirmContact',
            [
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'subject' => $request->subject,
                'message' => $request->message
            ]
        );

        $response = $mailer->send(
            'info@smash-up-randomizer.com',
            'New contact from Smash Up Randomizer',
            'New contact from Smash Up Randomizer. Name: ' . $request->name . ' Email: ' . $request->email . ' Phone: ' . $request->phone . ' Subject: ' . $request->subject . ' Message: ' . $request->message,
            'emails.contact',
            [
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'subject' => $request->subject,
                'message' => $request->message
            ]
        );

        return redirect()->back()
            ->with(['success' => 'Thank you for contact us. we will contact you shortly.']);
    }
}
