<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = User::with('roles');

        // Search functionality (case-insensitive)
        if ($request->filled('search')) {
            $search = strtolower($request->search);
            $query->where(function($q) use ($search) {
                $q->whereRaw('LOWER(name) LIKE ?', ['%' . $search . '%'])
                  ->orWhereRaw('LOWER(email) LIKE ?', ['%' . $search . '%']);
            });
        }

        // Filter by role
        if ($request->filled('role')) {
            $query->whereHas('roles', function($q) use ($request) {
                $q->where('name', $request->role);
            });
        }

        $users = $query->latest()->paginate(15)->withQueryString();
        $roles = Role::all();
        
        // Get stats for all users (not just paginated)
        $allUsersQuery = User::with('roles');
        if ($request->filled('search')) {
            $search = strtolower($request->search);
            $allUsersQuery->where(function($q) use ($search) {
                $q->whereRaw('LOWER(name) LIKE ?', ['%' . $search . '%'])
                  ->orWhereRaw('LOWER(email) LIKE ?', ['%' . $search . '%']);
            });
        }
        if ($request->filled('role')) {
            $allUsersQuery->whereHas('roles', function($q) use ($request) {
                $q->where('name', $request->role);
            });
        }
        $allUsers = $allUsersQuery->get();
        
        $stats = [
            'total' => $allUsers->count(),
            'verified' => $allUsers->where('email_verified_at', '!=', null)->count(),
            'unverified' => $allUsers->where('email_verified_at', null)->count(),
            'with_roles' => $allUsers->filter(function($user) {
                return $user->roles->isNotEmpty();
            })->count(),
        ];
        
        return view('backend.users.index', compact('users', 'roles', 'stats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all();
        return view('backend.users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Password::defaults()],
            'role' => ['required', 'exists:roles,name'],
            'last_login_location' => ['nullable', 'string', 'max:255'],
            'last_login_latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'last_login_longitude' => ['nullable', 'numeric', 'between:-180,180'],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'email_verified_at' => now(),
            'last_login_location' => $validated['last_login_location'] ?? null,
            'last_login_latitude' => $validated['last_login_latitude'] ?? null,
            'last_login_longitude' => $validated['last_login_longitude'] ?? null,
        ]);

        // Assign role
        $user->assignRole($validated['role']);

        return redirect()->route('admin.users.index')
            ->with('success', 'User created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $user->load('roles', 'permissions');
        return view('backend.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $roles = Role::all();
        $user->load('roles');
        return view('backend.users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'password' => ['nullable', 'confirmed', Password::defaults()],
            'role' => ['required', 'exists:roles,name'],
            'last_login_location' => ['nullable', 'string', 'max:255'],
            'last_login_latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'last_login_longitude' => ['nullable', 'numeric', 'between:-180,180'],
        ]);

        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'last_login_location' => $validated['last_login_location'] ?? $user->last_login_location,
            'last_login_latitude' => $validated['last_login_latitude'] ?? $user->last_login_latitude,
            'last_login_longitude' => $validated['last_login_longitude'] ?? $user->last_login_longitude,
        ]);

        // Update password if provided
        if (!empty($validated['password'])) {
            $user->update([
                'password' => Hash::make($validated['password']),
            ]);
        }

        // Sync roles
        $user->syncRoles([$validated['role']]);

        return redirect()->route('admin.users.index')
            ->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        // Prevent deleting yourself
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.index')
                ->with('error', 'You cannot delete your own account.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'User deleted successfully.');
    }
}

