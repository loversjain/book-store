<?php

namespace App\Http\Controllers\Web\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Services\TokenService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @param TokenService $tokenService
     */
    public function __construct(protected TokenService $tokenService){}

    /**
     * Show the login form to the user.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle the login request, authenticate the user and store the token.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(LoginRequest $request)
    {
        // Extract the credentials from the request
        $credentials = $request->only('email', 'password');

        try {
            // Attempt to generate the token with the provided credentials
            $token = $this->tokenService->generateToken($credentials['email'], $credentials['password']);

            // If token generation is successful, store it in the session
            if ($token) {
                session(['access_token' => $token]);

                // Redirect to the user profile page
                return redirect()->route('profile');
            } else {
                // If the token generation fails, redirect back with an error
                return redirect()->back()->with('error', 'Login failed. Please check your credentials and try again.');
            }
        } catch (\Exception $e) {
            // Log the error for debugging purposes
            Log::error('Login failed for user ' . $credentials['email'], ['exception' => $e]);

            // Redirect back with a general error message
            return redirect()->back()->with('error', 'An error occurred while trying to log you in. Please try again later.');
        }
    }

    /**
     * Display the user profile after a successful login.
     *
     * @return \Illuminate\View\View
     */
    public function profile()
    {
        // Retrieve the user data from the session
        $user = session('user');

        // If user data is available, show the profile view
        if ($user) {
            return view('auth.profile', compact('user'));
        }

        // If no user data found, redirect to login page with an error
        return redirect()->route('login')->with('error', 'You must be logged in to view your profile.');
    }

    /**
     * Handle user logout, clear session data, and redirect to the login page.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout()
    {
        try {
            // Call the logout method in the token service to clear the user's session
            $this->tokenService->logout();

            // Clear the session and redirect to the login page
            session()->flush();
            return redirect()->route('login')->with('success', 'You have been logged out successfully.');
        } catch (\Exception $e) {
            // Log the error for debugging purposes
            Log::error('Logout failed.', ['exception' => $e]);

            // Redirect to the login page with an error message
            return redirect()->route('login')->with('error', 'An error occurred during logout. Please try again later.');
        }
    }
}
