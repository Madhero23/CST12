<?php

/**
 * AuthController — Handles user authentication (login/logout).
 *
 * Satisfies: FR-AUTH-01, FR-AUTH-02, FR-AUTH-03, FR-AUTH-04, FR-AUTH-05, FR-AUTH-08
 *
 * Pre-existing state: This file DID NOT EXIST. Created from scratch.
 */

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class AuthController extends Controller
{
    /**
     * Display the login form.
     *
     * FR-AUTH-08: This is the target for unauthenticated redirects.
     *
     * @return \Illuminate\View\View
     */
    public function showLogin(): View
    {
        return view('welcome');
    }

    /**
     * Authenticate user and start session.
     *
     * FR-AUTH-01: Authenticate via Username + hashed password using Hash::check()
     * FR-AUTH-02: Generic error message — never reveals if username exists
     * FR-AUTH-03: Inline validation errors for empty Username/Password
     * FR-AUTH-04: Session regeneration on successful login
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request): RedirectResponse
    {
        try {
            // FR-AUTH-03: Validate required fields — triggers inline @error in Blade
            $request->validate([
                'Username' => 'required|string',
                'Password' => 'required|string',
            ]);

            // FR-AUTH-01: Fetch user by Username
            $user = User::where('Username', $request->Username)->first();

            // FR-AUTH-02: Same generic message for non-existent user OR wrong password
            if (!$user || !Hash::check($request->Password, $user->Password_Hash)) {
                return back()
                    ->withErrors(['login' => 'Invalid credentials. Please try again.'])
                    ->withInput($request->only('Username'));
            }

            // Check if user account is active
            if ($user->Status !== 'Active') {
                return back()
                    ->withErrors(['login' => 'Your account is inactive or suspended. Please contact an administrator.'])
                    ->withInput($request->only('Username'));
            }

            // FR-AUTH-01: Log the user in
            Auth::login($user, $request->boolean('remember'));

            // FR-AUTH-04: Regenerate session to prevent session fixation
            $request->session()->regenerate();

            // Update last login timestamp
            $user->Last_Login = now();
            $user->save();

            // FR-AUTH-08: Redirect to intended URL or dashboard
            return redirect()->intended('/admin');

        } catch (\Illuminate\Validation\ValidationException $e) {
            // Let validation exceptions pass through (for inline @error display)
            throw $e;
        } catch (\Exception $e) {
            \Log::error('Login failed: ' . $e->getMessage(), [
                'username' => $request->Username ?? 'unknown',
            ]);

            return back()
                ->withErrors(['login' => 'An unexpected error occurred. Please try again.'])
                ->withInput($request->only('Username'));
        }
    }

    /**
     * Log the user out and invalidate the session.
     *
     * FR-AUTH-05: Must call Auth::logout(), session()->invalidate(),
     *             and session()->regenerateToken() — all three required.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request): RedirectResponse
    {
        try {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        } catch (\Exception $e) {
            \Log::error('Logout failed: ' . $e->getMessage());
        }

        return redirect()->route('login');
    }
}
