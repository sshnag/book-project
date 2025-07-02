<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Storage;

class WeeklyReportMail extends Mailable
{
    use Queueable, SerializesModels;

    public $filePath;

    public function __construct($filePath)
    {
        $this->filePath = $filePath;
    }

   public function build()
{
    $fullPath = storage_path('app/public/' . $this->filePath);

    if (!file_exists($fullPath)) {
        throw new \Exception("Attachment file not found: " . $fullPath);
    }

    return $this->subject('📊 Weekly Bookstore Report')
                ->markdown('emails.reports.weekly')
                ->attach($fullPath);
}

}
