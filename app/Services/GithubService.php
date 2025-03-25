<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GithubService
{
    protected $baseUrl = 'https://api.github.com';
    protected $clientId;
    protected $clientSecret;

    public function __construct()
    {
        $this->clientId = config('services.github.client_id');
        $this->clientSecret = config('services.github.client_secret');
    }

    public function getUserRepositories($username)
    {
        try {
            $response = Http::withHeaders([
                'Accept' => 'application/vnd.github.v3+json',
            ])->get("{$this->baseUrl}/users/{$username}/repos", [
                'sort' => 'updated',
                'direction' => 'desc',
                'client_id' => $this->clientId,
                'client_secret' => $this->clientSecret,
            ]);

            if ($response->successful()) {
                return $response->json();
            }

            Log::error('GitHub API Error: ' . $response->body());
            return [];
        } catch (\Exception $e) {
            Log::error('GitHub Service Exception: ' . $e->getMessage());
            return [];
        }
    }

    public function getRepository($username, $repo)
    {
        try {
            $response = Http::withHeaders([
                'Accept' => 'application/vnd.github.v3+json',
            ])->get("{$this->baseUrl}/repos/{$username}/{$repo}", [
                'client_id' => $this->clientId,
                'client_secret' => $this->clientSecret,
            ]);

            if ($response->successful()) {
                return $response->json();
            }

            Log::error('GitHub API Error: ' . $response->body());
            return null;
        } catch (\Exception $e) {
            Log::error('GitHub Service Exception: ' . $e->getMessage());
            return null;
        }
    }
}