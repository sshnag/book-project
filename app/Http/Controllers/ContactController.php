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
    public function __construct(protected ContactRepository $repo) {}

    public function create()
    {
        return view('contact');
    }

    public function store(StoreContactRequest $request)
    {
        $this->repo->create($request->validated());
        return redirect()->back()->with('success', 'Thanks for reaching out! We’ll reply soon.');
    }

    public function index()
    {
        $contacts = $this->repo->getAllPaginated();
        return view('contact.index', compact('contacts'));
    }

    public function show($id)
    {
        $contact = $this->repo->find($id);

        if ($contact->status === 'new') {
            $contact->status = 'read';
            $contact->save();
        }

        return view('contact.show', compact('contact'));
    }

    public function destroy($id)
    {
        $contact = $this->repo->find($id);
        $contact->delete();

        return redirect()->route('admin.contacts.index')->with('success', 'Contact deleted.');
    }

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
