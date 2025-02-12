<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class TokenService
{
    /**
     * Generate an authentication token by sending credentials to the API.
     *
     * @param string $email
     * @param string $password
     * @return array|null
     */
    public function generateToken($email, $password)
    {
        try {
            // Send POST request to generate token
            $response = Http::post(config('swagger.api_base_url').'/token', [
                'email' => $email,
                'password' => $password,
            ]);

            // If the response is successful, store the token and user information in the session
            if ($response->successful()) {
                $data = $response->json();
                // Store the token, user information, and refresh token in session
                Session::put('access_token', $data['token_key']);
                Session::put('user', $data['user']);
                Session::put('refresh_token_key', $data['refresh_token_key']); // Store refresh token

                // Log token generation success
                Log::info('Token generated successfully for user: ' . $email);
                return $data;
            }

            // If unsuccessful, log the error
            Log::error('Token generation failed for user: ' . $email . ' with response: ' . $response->body());
            return null;
        } catch (\Exception $e) {
            // Log any exception that occurs during the request
            Log::error('Error generating token for user ' . $email . ': ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Refresh the authentication token using the refresh token.
     *
     * @return array|null
     */
    public function refreshToken()
    {
        try {
            $refreshToken = Session::get('refresh_token_key');

            if (!$refreshToken) {
                Log::error('No refresh token found in session.');
                return null;
            }

            // Send GET request to refresh the token using the refresh token
            $response = Http::get(config('swagger.api_base_url')."/token/refresh/{$refreshToken}");

            // If the response is successful, store the new token and user information in session
            if ($response->successful()) {
                $data = $response->json();
                // Store the new access token and refresh token in the session
                Session::put('access_token', $data['token_key']);
                Session::put('user', $data['user']);
                Session::put('refresh_token_key', $data['refresh_token_key']); // Store updated refresh token

                // Log token refresh success
                Log::info('Token refreshed successfully for user: ' . $data['user']['email']);
                return $data;
            }

            // If unsuccessful, log the error
            Log::error('Token refresh failed with response: ' . $response->body());
            return null;
        } catch (\Exception $e) {
            // Log any exception that occurs during the request
            Log::error('Error refreshing token: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Retrieve the authentication token from the session.
     *
     * @return string|null
     */
    public function getToken()
    {
        $token = Session::get('access_token');

        if (is_array($token)) {
            return $token['token_key'] ?? '';
        }

        return $token;
    }

    /**
     * Log out the user by clearing the session data.
     *
     * @return void
     */
    public function logout()
    {
        // Clear the session data related to authentication
        Session::forget('access_token');
        Session::forget('user');
        Session::forget('refresh_token_key'); // Also clear the refresh token

        // Log out action
        Log::info('User logged out and session cleared.');
    }
}
