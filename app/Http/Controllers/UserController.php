<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

/**
 * UserController
 * 
 * Phase 3: First real CRUD implementation
 * - Tenant-safe (scoped by tenant_id)
 * - Permission-guarded (via middleware)
 * - Audit-first (records all important actions)
 * - Plain Bootstrap views (no component library)
 */
class UserController extends Controller
{
    /**
     * Display a listing of users (tenant-scoped)
     */
    public function index()
    {
        $users = User::query()
            ->where('tenant_id', tenant_id())
            ->latest()
            ->limit(500)
            ->get();

        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new user
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created user
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users')->where(function ($query) {
                    return $query->where('tenant_id', tenant_id());
                }),
            ],
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'tenant_id' => tenant_id(),
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        // Audit-first: Record user creation
        audit()->record('users.created', $user, [
            'email' => $user->email,
            'name' => $user->name,
        ]);

        return redirect()
            ->route('users.index')
            ->with('success', 'User created successfully.');
    }

    /**
     * Show the form for editing the specified user
     */
    public function edit(User $user)
    {
        // Tenant-safe: Ensure user belongs to current tenant
        abort_if($user->tenant_id !== tenant_id(), 403, 'Unauthorized access to this user.');

        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified user
     */
    public function update(Request $request, User $user)
    {
        // Tenant-safe: Ensure user belongs to current tenant
        abort_if($user->tenant_id !== tenant_id(), 403, 'Unauthorized access to this user.');

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users')->where(function ($query) {
                    return $query->where('tenant_id', tenant_id());
                })->ignore($user->id),
            ],
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $oldData = $user->only(['name', 'email']);

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        
        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        // Audit-first: Record user update
        audit()->record('users.updated', $user, [
            'old' => $oldData,
            'new' => $user->only(['name', 'email']),
        ]);

        return redirect()
            ->route('users.index')
            ->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified user (AJAX-friendly)
     */
    public function destroy(User $user)
    {
        // Tenant-safe: Ensure user belongs to current tenant
        abort_if($user->tenant_id !== tenant_id(), 403, 'Unauthorized access to this user.');

        $userData = [
            'user_id' => $user->id,
            'email' => $user->email,
            'name' => $user->name,
        ];

        $user->delete();

        // Audit-first: Record user deletion
        audit()->record('users.deleted', $userData['user_id'], $userData);

        return response()->json(['ok' => true, 'message' => 'User deleted successfully.']);
    }
}
