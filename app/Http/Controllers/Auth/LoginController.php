<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

/**
 * Login Controller
 * 
 * Phase 1: Basic session-based authentication
 * Layer A: No starter kit, plain controller
 */
class LoginController extends Controller
{
    /**
     * Show login form
     *
     * @return View
     */
    public function show(): View
    {
        return view('auth.login');
    }

    /**
     * Handle login attempt
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        // Validate credentials
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $remember = $request->boolean('remember');

        // Attempt authentication
        if (!Auth::attempt($credentials, $remember)) {
            return back()
                ->withInput($request->only('email'))
                ->withErrors([
                    'email' => 'These credentials do not match our records.',
                ]);
        }

        // Regenerate session (security best practice)
        $request->session()->regenerate();

        // Redirect to intended page or dashboard
        return redirect()->intended(route('dashboard'));
    }

    /**
     * Handle logout
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function destroy(Request $request): RedirectResponse
    {
        // Logout user
        Auth::logout();

        // Invalidate session
        $request->session()->invalidate();

        // Regenerate CSRF token
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('success', 'You have been logged out successfully.');
    }
}
