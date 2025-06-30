<?php
namespace App\Repositories;

use App\Models\Contact;
use Illuminate\Support\Facades\Auth;

class ContactRepository
{
    public function create(array $data)
    {
        return Contact::create([
            'name'       => $data['name'],
            'email'      => $data['email'],
            'message'    => $data['message'],
            'book_title' => $data['book_title'] ?? null,
            'status'     => 'new',
            'user_id'    => Auth::check() ? Auth::id() : null,
        ]);
    }

    public function getAllPaginated($perPage = 10)
    {
        return Contact::orderBy('created_at', 'desc')->simplePaginate($perPage);
    }

    public function find($id)
    {
        return Contact::findOrFail($id);
    }

    public function updateStatus(Contact $contact, string $newStatus): bool|string
    {
        if (($contact->status === 'read' || $contact->status === 'replied') && $newStatus === 'new') {
            return 'You cannot set the status back to "New".';
        }

        $contact->status = $newStatus;
        return $contact->save();
    }
}
