<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class GithubController extends Controller
{
    public function repositories(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
        ]);

        try {
            $response = Http::get("https://api.github.com/users/{$request->username}/repos", [
                'sort' => 'updated',
                'per_page' => 100,
            ]);

            if ($response->failed()) {
                return response()->json([
                    'error' => 'Failed to fetch GitHub repositories'
                ], 400);
            }

            $repos = $response->json();
            
            // Filter and transform the data
            $repositories = collect($repos)->map(function ($repo) {
                return [
                    'name' => $repo['name'],
                    'description' => $repo['description'],
                    'url' => $repo['html_url'],
                    'language' => $repo['language'],
                    'stars' => $repo['stargazers_count'],
                    'forks' => $repo['forks_count'],
                    'updated_at' => $repo['updated_at'],
                ];
            })->filter(function ($repo) {
                // Filter out forked repositories and those without a main language
                return $repo['language'] !== null;
            })->values();

            return response()->json($repositories);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to fetch GitHub repositories'
            ], 500);
        }
    }

    public function import(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'repositories' => 'required|array',
            'repositories.*' => 'required|string',
            'portfolio_id' => 'required|exists:portfolios,id'
        ]);

        try {
            $portfolio = auth()->user()->portfolios()->findOrFail($request->portfolio_id);
            $projects = [];

            foreach ($request->repositories as $repoName) {
                $response = Http::get("https://api.github.com/repos/{$request->username}/{$repoName}");
                
                if ($response->successful()) {
                    $repo = $response->json();
                    $projects[] = [
                        'name' => $repo['name'],
                        'description' => $repo['description'],
                        'url' => $repo['html_url'],
                        'language' => $repo['language'],
                        'stars' => $repo['stargazers_count'],
                        'forks' => $repo['forks_count'],
                    ];
                }
            }

            // Update the portfolio's projects
            $currentProjects = $portfolio->projects ?? [];
            $portfolio->update([
                'projects' => array_merge($currentProjects, $projects)
            ]);

            return response()->json([
                'message' => 'Projects imported successfully',
                'projects' => $projects
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to import GitHub repositories'
            ], 500);
        }
    }
} 