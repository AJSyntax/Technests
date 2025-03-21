<?php

namespace App\Http\Controllers;

use App\Models\Portfolio;
use App\Models\Template;
use App\Services\ImageKitService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Http\Requests\PortfolioRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller;

class PortfolioController extends Controller
{
    use AuthorizesRequests, ValidatesRequests;
    
    protected $imageKit;

    public function __construct(ImageKitService $imageKit)
    {
        $this->imageKit = $imageKit;
    }

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

        return view('portfolios.create', [
            'templates' => Cache::remember('templates.all', 3600, function () {
                return Template::all();
            })
        ]);
    }

    public function store(PortfolioRequest $request)
    {
        $this->authorize('create', Portfolio::class);

        $portfolio = Auth::user()->portfolios()->create($request->validated());

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

        return view('portfolios.edit', compact('portfolio'));
    }

    public function update(PortfolioRequest $request, Portfolio $portfolio)
    {
        $this->authorize('update', $portfolio);

        $data = $request->validated();

        // Handle profile picture upload
        if ($request->hasFile('profile_picture')) {
            try {
                // Delete existing profile picture if it exists
                if ($portfolio->profile_picture_file_id) {
                    $this->imageKit->deleteImage($portfolio->profile_picture_file_id);
                }

                // Upload new profile picture
                $result = $this->imageKit->uploadImage(
                    $request->file('profile_picture'),
                    'portfolio-pictures'
                );

                $data['profile_picture_url'] = $result['url'];
                $data['profile_picture_path'] = $result['path'];
                $data['profile_picture_file_id'] = $result['fileId'];
            } catch (\Exception $e) {
                return back()->withErrors(['profile_picture' => $e->getMessage()])->withInput();
            }
        }

        $portfolio->update($data);

        Cache::forget("user." . Auth::id() . ".portfolios");
        Cache::forget("portfolio.{$portfolio->id}");

        return back()->with('success', 'Portfolio updated successfully.');
    }

    public function preview(Portfolio $portfolio)
    {
        $this->authorize('view', $portfolio);

        $portfolio->load(['template', 'skills', 'projects', 'experiences', 'education', 'certifications']);

        return view('portfolios.preview', compact('portfolio'));
    }

    public function show(Portfolio $portfolio)
    {
        if (!$portfolio->is_public) {
            abort(404);
        }

        $portfolio->load(['template', 'skills', 'projects', 'experiences', 'education', 'certifications']);

        return view('portfolios.show', compact('portfolio'));
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
        $this->authorize('duplicate', $portfolio);

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