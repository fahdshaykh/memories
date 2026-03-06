<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $contacts = Contact::latest()->paginate(10);
        return view('dashboard.contacts.index', compact('contacts'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Contact $contact)
    {
        // Mark as read when viewed
        $contact->update(['is_read' => true]);

        return view('dashboard.contacts.show', compact('contact'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contact $contact)
    {
        $contact->delete();

        return redirect()->route('contacts.index')
            ->with('success', 'Contact message deleted successfully.');
    }

    /**
     * Mark contact as unread.
     */
    public function markAsUnread(Contact $contact)
    {
        $contact->update(['is_read' => false]);

        return redirect()->route('contacts.index')
            ->with('success', 'Contact marked as unread.');
    }

    /**
     * Mark contact as read.
     */
    public function markAsRead(Contact $contact)
    {
        $contact->update(['is_read' => true]);

        return redirect()->route('contacts.index')
            ->with('success', 'Contact marked as read.');
    }
}
