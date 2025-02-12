<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\TokenService;
use Illuminate\Support\Facades\Http;

class CreateAuthor extends Command
{
    protected $signature = 'create:author';
    protected $description = 'Create a new author by providing their details';

    protected $tokenService;

    public function __construct(TokenService $tokenService)
    {
        parent::__construct();
        $this->tokenService = $tokenService;
    }

    public function handle()
    {
        // Ask the user for the required author details with validation
        $firstName = $this->askForValidInput('Enter the author first name');
        $lastName = $this->askForValidInput('Enter the author last name');
        $birthday = $this->askForValidInput('Enter the author birthday (YYYY-MM-DD)');
        $biography = $this->askForValidInput('Enter the author biography');
        $gender = $this->choice('Select the author gender', ['male', 'female'], 0); // Default to 'male'
        $placeOfBirth = $this->askForValidInput('Enter the author place of birth');

        $authorData = [
            'first_name' => $firstName,
            'last_name' => $lastName,
            'birthday' => $birthday,
            'biography' => $biography,
            'gender' => $gender,
            'place_of_birth' => $placeOfBirth,
        ];

        $tokenData = $this->tokenService->generateToken(config('swagger.email'), config('swagger.password'));

        if ($tokenData) {
            $token = $tokenData['token_key'];
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
            ])->post(config('swagger.api_base_url').'/authors', $authorData);

            if ($response->successful()) {
                $this->info('Author created successfully!');
                $this->line(json_encode($response->json(), JSON_PRETTY_PRINT));
            } else {
                $this->error('Failed to create author');
                $this->line(json_encode($response->json(), JSON_PRETTY_PRINT));
            }
        } else {
            // Token generation failed
            $this->error('Failed to generate token. Please check your credentials and try again.');
        }
    }

    private function askForValidInput($prompt)
    {
        do {
            $input = $this->ask($prompt);
            if (empty(trim($input))) {
                $this->error('Input cannot be empty or just spaces. Please try again.');
            }
        } while (empty(trim($input)));

        return $input;
    }
}
