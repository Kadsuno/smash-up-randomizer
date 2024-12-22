<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;

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
  
        return redirect()->back()
                         ->with(['success' => 'Thank you for contact us. we will contact you shortly.']);
    }
}
