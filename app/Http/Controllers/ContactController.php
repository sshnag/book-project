<?php
namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\User;
use App\Repositories\ContactRepository;
use App\Http\Requests\StoreContactRequest;
use App\Notifications\ContactRepliedNotification;
use Illuminate\Support\Facades\Notification;

class ContactController extends Controller
{
    /**
     * ContactController constructor.
     * Injects the ContactRepository.
     * @author - SSA
     * @param  ContactRepository  $repo
     */
    public function __construct(protected ContactRepository $repo) {}

    /**
     * Show the contact form page to the user.
     * @author - SSA
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('contact');
    }

    /**
     * Store a newly submitted contact message in storage.
     * @author - SSA
     * @param  \App\Http\Requests\StoreContactRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreContactRequest $request)
    {
        $this->repo->create($request->validated());
        return redirect()->back()->with('success', 'Thanks for reaching out! We’ll reply soon.');
    }

    /**
     * Display a paginated list of all contact messages for admin panel use.
     * Accessible only by authorized users (e.g., admin).
     * @author - SSA
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $contacts = $this->repo->getAllPaginated();
        return view('contact.index', data: compact('contacts'));
    }

    /**
     * Display the details of a single contact message.
     * Also marks it as 'read' if it was previously 'new'.
     * Used in admin panel to view user messages in detail.
     * @author - SSA
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $contact = $this->repo->find($id);

        if ($contact->status === 'new') {
            $contact->status = 'read';
            $contact->save();
        }

        return view('contact.show', compact('contact'));
    }

    /**
     * Delete a specific contact message from storage.
     * Only accessible to admins for removing unwanted or resolved messages.
     * @author - SSA
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Contact $contact,$id)
    {
        $this->authorize('delete',$contact);
        $contact = $this->repo->find($id);
        $contact->delete();

        return redirect()->route('admin.contacts.index')->with('success', 'Contact deleted.');
    }

    /**
     * Update the status of a contact message.
     * Sends a notification to the user if marked as 'replied'.
     * Status values might include 'read', 'pending', 'replied', etc.
     * @author - SSA
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateStatus($id)
    {
        $contact = $this->repo->find($id);
        $status = request('status');

        $result = $this->repo->updateStatus($contact, $status);

        if ($result !== true) {
            return back()->with('error', $result);
        }

        if ($status === 'replied' && $contact->user_id) {
            $user = User::find($contact->user_id);
            if ($user) {
                $user->notify(new ContactRepliedNotification($contact));
            }
        }

        return redirect()->route('admin.contacts.index')->with('success', 'Status updated.');
    }
}
