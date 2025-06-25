<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use JeroenNoten\LaravelAdminLte\View\Components\Tool\Datatable;
use Yajra\DataTables\DataTables;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //User list table using Yajra datatable
        $users = User::paginate(10);

         if ($request->ajax()) {
            return DataTables::of(User::with('roles'))
                ->addColumn('role', fn($user) => $user->roles->pluck('name')->implode(', '))
                ->addColumn('action', fn($user) => view('users.partials.action', compact('user'))->render())
                ->rawColumns(['action'])
                ->make(true);
        }
                    $users=User::simplePaginate(5); //[pagination]


        return view('user.index', compact('users'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
     public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User is archived!');
    }
}
