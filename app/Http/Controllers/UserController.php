<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a paginated list of users excluding superadmins.
     * Only accessible to users authorized to manage users.
     * @author - SSA
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        Gate::authorize('manage-users');

        $users = User::whereDoesntHave('roles', function ($query) {
            $query->where('name', 'superadmin');
        })->latest()->paginate(7);

        return view('user.index', compact('users'));
    }

    /**
     * Show the form for creating a new user.
     * Authorization required to manage users.
     * @author - SSA
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        $this->authorize('manage users');
        return view('user.create');
    }

    /**
     * Store a newly created user in storage after validating input.
     * Automatically hashes the password before storing.
     * @author - SSA
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $this->authorize('manage users');

        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User created successfully!');
    }

    /**
     * Show the form for editing the specified user’s roles and permissions.
     * Excludes the 'superadmin' role from the selection list.
     * @author - SSA
     * @param  \App\Models\User  $user
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(User $user)
    {
        $roles = Role::where('name', '!=', 'superadmin')->get();
        $permissions = Permission::all();

        return view('user.edit', compact('user', 'roles', 'permissions'));
    }

    /**
     * Update the specified user’s roles and permissions.
     * Syncs the user’s current roles and permissions with new ones.
     * @author - SSA
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|exists:roles,name',
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,name',
        ]);

        $user->syncRoles([$request->role]);
        $user->syncPermissions($request->permissions ?? []);

        return redirect()->route('admin.users.index')->with('success', 'User role and permissions updated successfully!');
    }

    /**
     * Assign a single role to the specified user.
     * Requires authorization to assign roles.
     * @author - SSA
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function assignRole(Request $request, User $user)
    {
        $this->authorize('assign roles');

        $request->validate([
            'role' => 'required|exists:roles,name',
        ]);

        $user->syncRoles([$request->role]);

        return back()->with('success', 'Role assigned successfully!');
    }
}
