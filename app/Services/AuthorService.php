<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class AuthorService
{
    public function __construct(protected TokenService $tokenService){}

    /**
     * Fetch a list of authors from the external API.
     *
     * @return array|null
     */
    protected function getToken() : string{
        return $this->tokenService->getToken();
    }
    public function getAuthors()
    {
        try {

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->getToken(),
            ])->get(config('swagger.api_base_url').'/authors');

            if ($response->successful()) {
                return $response->json();
            } else {
                Log::error('Failed to fetch authors', ['error' => $response->json()]);
                return null;
            }
        } catch (\Exception $e) {
            Log::error('Error fetching authors', ['exception' => $e]);
            return null;
        }
    }

    /**
     * Fetch a specific author by ID from the external API.
     *
     * @param int $author_id
     * @return array|null
     */
    public function getAuthor($author_id)
    {
        try {

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->getToken(),
            ])->get(config('swagger.api_base_url')."/{$author_id}");

            if ($response->successful()) {
                return $response->json();
            } else {
                Log::error('Failed to fetch author', ['error' => $response->json()]);
                return null;
            }
        } catch (\Exception $e) {
            Log::error('Error fetching author by ID', ['exception' => $e]);
            return null;
        }
    }

    /**
     * Create a new author via the external API.
     *
     * @param array $authorData
     * @return bool
     */
    public function createAuthor($authorData)
    {
        try {

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->getToken(),
            ])->post(config('swagger.api_base_url').'/authors', $authorData);

            if ($response->successful()) {
                return true;
            } else {
                Log::error('Failed to create author', ['error' => $response->json()]);
                return false;
            }
        } catch (\Exception $e) {
            Log::error('Error creating author', ['exception' => $e]);
            return false;
        }
    }

    /**
     * Delete an author via the external API.
     *
     * @param int $author_id
     * @return bool
     */
    public function deleteAuthor($author_id)
    {
        try {

            // Fetch the author data to check if there are related books
            $authorResponse = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->getToken(),
            ])->get(config('swagger.api_base_url')."/authors/{$author_id}");

            if (!$authorResponse->successful()) {
                Log::error('Failed to fetch author data', ['error' => $authorResponse->json()]);
                return false;
            }

            $authorData = $authorResponse->json();

            // Check if the author has related books
            if (isset($authorData['books']) && count($authorData['books']) > 0) {
                return "has_books";
            }

            // Proceed with the deletion
            $deleteResponse = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->getToken(),
            ])->delete(config('swagger.api_base_url')."/authors/{$author_id}");

            return $deleteResponse->successful();
        } catch (\Exception $e) {
            Log::error('Error deleting author', ['exception' => $e]);
            return false;
        }
    }
}
