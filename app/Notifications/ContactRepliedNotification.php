<?php

namespace App\Notifications;

use App\Models\Contact;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ContactRepliedNotification extends Notification
{
    use Queueable;
     protected $contact;
    /**
     * Create a new notification instance.
     */
    public function __construct(Contact $contact)
    {
        //
        $this->contact=$contact;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toDatabase  ($notifiable)
    {
        return[
            'message'=>'Your message has been replied by admin',
            'contact_id'=>$this->contact->id
        ];

    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
