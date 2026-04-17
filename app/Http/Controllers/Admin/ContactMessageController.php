<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class ContactMessageController extends Controller
{
    /**
     * Paginated list of contact form submissions.
     */
    public function index(Request $request): View
    {
        $contacts = Contact::query()
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('backend.contacts.index', [
            'contacts' => $contacts,
        ]);
    }

    /**
     * Show a single contact message.
     */
    public function show(Contact $contact): View
    {
        return view('backend.contacts.show', [
            'contact' => $contact,
        ]);
    }
}
