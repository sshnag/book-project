<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('contact');
    }
    public function getData(Request $request)
    {
        $query = Contact::query();

        return DataTables::of($query)
            ->addColumn('action', function ($row) {
                return '<button class="btn btn-sm btn-outline-secondary disabled">View</button>';
            })
            ->editColumn('created_at', function ($row) {
                return $row->created_at->format('d M Y h:i A');
            })
            ->editColumn('status', function ($row) {
                $badgeColor = match ($row->status) {
                    'new' => 'warning',
                    'read' => 'info',
                    'replied' => 'success',
                    default => 'secondary',
                };
                return '<span class="badge bg-' . $badgeColor . '">' . ucfirst($row->status) . '</span>';
            })
            ->rawColumns(['action', 'status'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('contact');
    }
    // public function send(Request $request)
    // {
    //     $request
    // }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=> 'required|string|max:255',
            'email'=>'required|email|max:255',
            'message'=>'required|string',
            'book_title'=>'nullable|string|max:255',
        ]);
        Contact ::create([
            'name'=> $request->name,
            'email'=> $request->email,
            'message'=> $request->message,
            'book_title'=>$request->book_title,
            'status'=>'new', //default
        ]);
        return redirect()->back()->with('success','Your Message has been sent!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
