<?php

namespace App\Http\Controllers;

use App\Models\Portfolio;
use App\Models\Template;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class PortfolioController extends Controller
{
    public function index()
    {
        $portfolios = Cache::remember("user." . Auth::id() . ".portfolios", 3600, function () {
            return Auth::user()->portfolios()
                ->with(['template', 'skills', 'projects'])
                ->latest()
                ->paginate(9);
        });

        return response()->json($portfolios);
    }

    public function create()
    {
        $this->authorize('create', Portfolio::class);

        return view('portfolio.create', [
            'templates' => Cache::remember('templates.all', 3600, function () {
                return Template::all();
            })
        ]);
    }

    public function store(Request $request)
    {
        $this->authorize('create', Portfolio::class);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'template_id' => 'required|exists:templates,id',
            'title' => 'nullable|string|max:255',
            'bio' => 'nullable|string',
            'contact_email' => 'nullable|email',
            'phone' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'website' => 'nullable|url',
            'github_username' => 'nullable|string|max:255',
            'linkedin_url' => 'nullable|url',
            'is_public' => 'boolean',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $portfolio = Auth::user()->portfolios()->create($validator->validated());

        Cache::forget("user." . Auth::id() . ".portfolios");

        return response()->json([
            'message' => 'Portfolio created successfully.',
            'portfolio' => $portfolio
        ], 201);
    }

    public function edit(Portfolio $portfolio)
    {
        $this->authorize('update', $portfolio);

        $portfolio->load(['template', 'skills', 'projects', 'experiences', 'education', 'certifications']);

        return view('portfolio.edit', compact('portfolio'));
    }

    public function update(Request $request, Portfolio $portfolio)
    {
        $this->authorize('update', $portfolio);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'title' => 'nullable|string|max:255',
            'bio' => 'nullable|string',
            'contact_email' => 'nullable|email',
            'phone' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'website' => 'nullable|url',
            'github_username' => 'nullable|string|max:255',
            'linkedin_url' => 'nullable|url',
            'is_public' => 'boolean',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $portfolio->update($validator->validated());

        Cache::forget("user." . Auth::id() . ".portfolios");
        Cache::forget("portfolio.{$portfolio->id}");

        return response()->json([
            'message' => 'Portfolio updated successfully.',
            'portfolio' => $portfolio
        ]);
    }

    public function preview(Portfolio $portfolio)
    {
        $this->authorize('view', $portfolio);

        $portfolio->load(['template', 'skills', 'projects', 'experiences', 'education', 'certifications']);

        return view('portfolio.preview', compact('portfolio'));
    }

    public function show(Portfolio $portfolio)
    {
        if (!$portfolio->is_public) {
            abort(404);
        }

        $portfolio->load(['template', 'skills', 'projects', 'experiences', 'education', 'certifications']);

        return view('portfolio.show', compact('portfolio'));
    }

    public function destroy(Portfolio $portfolio)
    {
        $this->authorize('delete', $portfolio);

        $portfolio->delete();

        Cache::forget("user." . Auth::id() . ".portfolios");
        Cache::forget("portfolio.{$portfolio->id}");

        return response()->json(['message' => 'Portfolio deleted successfully']);
    }

    public function bulkDelete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'portfolio_ids' => 'required|array',
            'portfolio_ids.*' => 'exists:portfolios,id'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $portfolios = Portfolio::whereIn('id', $validator->validated()['portfolio_ids'])
            ->where('user_id', Auth::id())
            ->get();

        foreach ($portfolios as $portfolio) {
            $this->authorize('delete', $portfolio);
            $portfolio->delete();
        }

        Cache::forget("user." . Auth::id() . ".portfolios");

        return response()->json(['message' => 'Selected portfolios deleted successfully']);
    }

    public function search(Request $request)
    {
        $query = Auth::user()->portfolios();

        if ($request->has('name')) {
            $query->where('name', 'like', "%{$request->name}%");
        }

        if ($request->has('title')) {
            $query->where('title', 'like', "%{$request->title}%");
        }

        if ($request->has('is_public')) {
            $query->where('is_public', $request->boolean('is_public'));
        }

        if ($request->has('template_id')) {
            $query->where('template_id', $request->template_id);
        }

        $portfolios = $query->with(['template', 'skills', 'projects'])
            ->latest()
            ->paginate($request->per_page ?? 9);

        return response()->json($portfolios);
    }

    public function duplicate(Portfolio $portfolio)
    {
        $this->authorize('create', Portfolio::class);

        $newPortfolio = $portfolio->replicate();
        $newPortfolio->name = $portfolio->name . ' (Copy)';
        $newPortfolio->user_id = Auth::id();
        $newPortfolio->save();

        // Duplicate related records
        foreach ($portfolio->skills as $skill) {
            $newPortfolio->skills()->create($skill->toArray());
        }

        foreach ($portfolio->projects as $project) {
            $newPortfolio->projects()->create($project->toArray());
        }

        foreach ($portfolio->experiences as $experience) {
            $newPortfolio->experiences()->create($experience->toArray());
        }

        foreach ($portfolio->education as $education) {
            $newPortfolio->education()->create($education->toArray());
        }

        foreach ($portfolio->certifications as $certification) {
            $newPortfolio->certifications()->create($certification->toArray());
        }

        Cache::forget("user." . Auth::id() . ".portfolios");

        return response()->json([
            'message' => 'Portfolio duplicated successfully.',
            'portfolio' => $newPortfolio
        ]);
    }
} 