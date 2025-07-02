<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Book;
use Illuminate\Support\Facades\Mail;
use App\Mail\WeeklyBookReport;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Illuminate\Support\Facades\Storage;
use App\Mail\WeeklyReportMail;

class SendWeeklyBookReport extends Command
{
    protected $signature = 'books:weekly-report';
    protected $description = 'Generate weekly book report and send to admin';

    public function handle()
    {
        $lastWeek = now()->subWeek();

        $newBooks = Book::where('created_at', '>=', $lastWeek)->get();
        $topDownloads = Book::orderByDesc('download_count')->take(5)->get();
        $totalDownloads = Book::sum('download_count');

        $data = [
            'newBooks'       => $newBooks,
            'topDownloads'   => $topDownloads,
            'totalDownloads' => $totalDownloads,
        ];

        // Generate PDF from Blade
        $pdf = PDF::loadView('reports.weekly', $data);
        $pdfPath = 'reports/weekly_report_' . now()->format('Ymd_His') . '.pdf';
        Storage::disk('public')->put($pdfPath, $pdf->output());

        // Email with attachment
        Mail::to('shinshinaung1506@gmail.com')->send(new WeeklyReportMail($pdfPath));

        $this->info('Weekly report sent successfully.');
    }
}
