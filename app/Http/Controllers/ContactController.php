<?php
namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

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
            'name'       => 'required|string|max:255',
            'email'      => 'required|email|max:255',
            'message'    => 'required|string',
            'book_title' => 'nullable|string|max:255',
        ]);

        Contact::create([
            'name'       => $request->name,
            'email'      => $request->email,
            'message'    => $request->message,
            'book_title' => $request->book_title,
            'status'     => 'new',
        ]);

    return redirect()->back()->with('success', 'Thanks for reaching out! We’ll reply as soon as possible.');
    }

    // Admin contact management

    public function index()
    {
        $contacts = Contact::orderBy('created_at', 'desc')->simplePaginate(5);
        return view('contact.index', compact('contacts'));

    }
       public function destroy($id)
    {
        $contact = Contact::findOrFail($id);

        $contact->delete();

        return redirect()->route('admin.contacts.index')->with('success', 'Contact message deleted successfully.');
    }
    public function updateStatus($id, Request $request)
{
    //updating the status of messages only admin can edit
    $contact = Contact::findOrFail($id);

    $request->validate([
        'status' => 'required|in:new,read,replied',
    ]);

    $contact->status = $request->status;
    $contact->save();

    return redirect()->route('admin.contacts.index')->with('success', 'Status updated successfully.');
}
public function show($id)
{
    $contact = Contact::findOrFail($id);

    //  Auto mark as "read" when admin views it
    if ($contact->status === 'new') {
        $contact->status = 'read';
        $contact->save();
    }

    return view('contact.show', compact('contact'));
}

    // public function getData(Request $request)
    // {
    //     $query = Contact::query();

    //     return DataTables::of($query)
    //         ->addColumn('action', function ($contact) {
    //             return view('contacts.partials.action', compact('contact'))->render();
    //         })
    //         ->editColumn('created_at', function ($contact) {
    //             return $contact->created_at->format('d M Y h:i A');
    //         })
    //         ->editColumn('status', function ($contact) {
    //             $badgeColor = match ($contact->status) {
    //                 'new' => 'warning',
    //                 'read' => 'info',
    //                 'replied' => 'success',
    //                 default => 'secondary',
    //             };
    //             return '<span class="badge bg-'.$badgeColor.'">'.ucfirst($contact->status).'</span>';
    //         })
    //         ->editColumn('message', function ($contact) {
    //             return Str::limit($contact->message, 50);
    //         })
    //         ->rawColumns(['action', 'status', 'message'])
    //         ->make(true);
    // }

    // public function adminShow(Contact $contact)
    // {
    //     // Mark as read if not already
    //     if ($contact->status === 'new') {
    //         $contact->update(['status' => 'read']);
    //     }

    //     return view('admin.contacts.show', compact('contact'));
    // }

    // public function adminDestroy(Contact $contact)
    // {
    //     $contact->delete();
    //     return redirect()->route('admin.contacts.index')
    //         ->with('success', 'Contact message deleted successfully');
    // }
}
