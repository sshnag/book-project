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
    public function index(Request $request)
    {
        $this->authorize('manage users');

        $users = User::whereDoesntHave('roles', function ($query) {
            $query->where('name', 'superadmin');
        })->latest()->simplePaginate(7);

        return view('user.index', compact('users'));
    }

    public function create()
    {
        $this->authorize('manage users');
        return view('user.create');
    }

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
    public function edit(User $user)
{
    $roles = Role::where('name', '!=', 'superadmin')->get();
    $permissions = Permission::all();   // Spatie permissions
    return view('user.edit', compact('user', 'roles', 'permissions'));
}
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
