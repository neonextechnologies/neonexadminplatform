<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

/**
 * Register Controller
 * 
 * Phase 1: Basic user registration
 * Layer A: No starter kit, plain controller
 * Audit-first: Records user creation event (stub for now, full implementation in Phase 3)
 */
class RegisterController extends Controller
{
    /**
     * Show registration form
     *
     * @return View
     */
    public function show(): View
    {
        return view('auth.register');
    }

    /**
     * Handle registration
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        // Validate input
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        // Create user
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        // 🔒 Audit-first: Log user creation
        // Phase 1: Stub implementation (logs to Laravel log)
        // Phase 3: Will use AuditContract implementation
        $this->auditUserCreation($user, $request);

        // Login user automatically
        Auth::login($user);

        // Regenerate session
        $request->session()->regenerate();

        return redirect()->route('dashboard')
            ->with('success', 'Welcome! Your account has been created successfully.');
    }

    /**
     * Audit user creation (Audit-first approach)
     * 
     * Phase 1: Logs to Laravel log (stub)
     * Phase 3: Will use app('audit')->record()
     *
     * @param User $user
     * @param Request $request
     * @return void
     */
    protected function auditUserCreation(User $user, Request $request): void
    {
        // Phase 1: Simple logging (stub for audit system)
        logger()->info('User created', [
            'user_id' => $user->id,
            'email' => $user->email,
            'name' => $user->name,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'created_at' => $user->created_at->toDateTimeString(),
        ]);

        // Phase 3: Will be replaced with:
        // app('audit')->record('created', $user, [], [
        //     'ip_address' => $request->ip(),
        //     'user_agent' => $request->userAgent(),
        // ]);
    }
}
