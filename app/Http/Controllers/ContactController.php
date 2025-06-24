<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Str;
class ContactController extends Controller
{
    // Frontend contact form
    public function create()
    {
        return view('contact');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string',
            'book_title' => 'nullable|string|max:255',
        ]);

        Contact::create([
            'name' => $request->name,
            'email' => $request->email,
            'message' => $request->message,
            'book_title' => $request->book_title,
            'status' => 'new',
        ]);

        return redirect()->back()->with('success', 'Your Message has been sent!');
    }

    // Admin contact management
    public function adminIndex()
    {
        return view('contacts.index');
    }

    public function getData(Request $request)
    {
        $query = Contact::query();

        return DataTables::of($query)
            ->addColumn('action', function ($contact) {
                return view('contacts.partials.action', compact('contact'))->render();
            })
            ->editColumn('created_at', function ($contact) {
                return $contact->created_at->format('d M Y h:i A');
            })
            ->editColumn('status', function ($contact) {
                $badgeColor = match ($contact->status) {
                    'new' => 'warning',
                    'read' => 'info',
                    'replied' => 'success',
                    default => 'secondary',
                };
                return '<span class="badge bg-'.$badgeColor.'">'.ucfirst($contact->status).'</span>';
            })
            ->editColumn('message', function ($contact) {
                return Str::limit($contact->message, 50);
            })
            ->rawColumns(['action', 'status', 'message'])
            ->make(true);
    }

    public function adminShow(Contact $contact)
    {
        // Mark as read if not already
        if ($contact->status === 'new') {
            $contact->update(['status' => 'read']);
        }

        return view('admin.contacts.show', compact('contact'));
    }

    public function adminDestroy(Contact $contact)
    {
        $contact->delete();
        return redirect()->route('admin.contacts.index')
            ->with('success', 'Contact message deleted successfully');
    }
}
