<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Mail\QueryMail;
use App\Mail\ContactFormSubmitted;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        try {
            $contact = Contact::create($request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'message' => 'required|string'
            ]) + ['is_read' => false]);

            try {
                // Send both emails
                Mail::to($contact->email)->send(new ContactFormSubmitted($contact));
                // Mail::to('associationbpl@gmail.com')->send(new QueryMail($contact));
                Mail::to('info.associationbpl@gmail.com')->send(new QueryMail($contact));

                return response()->json([
                    'success' => true,
                    'message' => 'Thank you for contacting us. We will get back to you soon.'
                ]);
            } catch (\Exception $e) {

                return response()->json([
                    'success' => true,
                    'message' => 'Your message has been received. However, there might be a delay in our response.'
                ]);
            }
        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while processing your request. Please try again later.'
            ], 500);
        }
    }

    public function index()
    {
        $this->authorize('viewAny', Contact::class);
        $contacts = Contact::latest()->paginate(10);
        return view('admin.contacts.index', compact('contacts'));
    }

    public function show(Contact $contact)
    {
        $this->authorize('view', Contact::class);
        $contact->update(['is_read' => true]);
        return view('admin.contacts.show', compact('contact'));
    }

    public function destroy(Contact $contact)
    {
        $this->authorize('delete', Contact::class);
        $contact->delete();
        return redirect()->route('contacts.index')->with('success', 'Contact message deleted successfully');
    }
}
