<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class BookService
{
    public function __construct( protected TokenService $tokenService){}

    protected function getToken() : string{
        return $this->tokenService->getToken();
    }
    /**
     * Store a new book in the system.
     *
     * @param array $bookData
     * @param string $token
     * @return array|null
     */
    public function storeBook(array $bookData)
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->getToken(),
            ])->post(config('swagger.api_base_url').'/books', $bookData);

            // Return the response if successful
            if ($response->successful()) {
                return $response->json();
            }

            Log::error('Failed to create book: ' . $response->body());
            return null;
        } catch (\Exception $e) {
            // Log the error for debugging purposes
            Log::error('Error creating book: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Delete a book from the system.
     *
     * @param int $bookId
     * @param string $token
     * @return bool
     */
    public function deleteBook(int $bookId): bool
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->getToken(),
            ])->delete(config('swagger.api_base_url')."/books/{$bookId}");

            return $response->successful();
        } catch (\Exception $e) {
            // Log the error for debugging purposes
            Log::error('Error deleting book: ' . $e->getMessage());
            return false;
        }
    }
}
