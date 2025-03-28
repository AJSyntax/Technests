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
use Illuminate\Support\Facades\Storage;
use ZipArchive;
use App\Services\PortfolioDownloadService;
use Exception;

class PortfolioController extends Controller
{
    use AuthorizesRequests, ValidatesRequests;
    
    protected $imageKit;

    public function __construct(ImageKitService $imageKit)
    {
        $this->imageKit = $imageKit;
        $this->middleware('auth');
    }

    public function index()
    {
        $portfolios = auth()->user()->portfolios()->latest()->paginate(9);
        return view('portfolios.index', compact('portfolios'));
    }

    public function create()
    {
        $templates = Template::where('is_premium', false)->get();
        $premiumTemplates = Template::where('is_premium', true)->get();
        return view('portfolios.create', compact('templates', 'premiumTemplates'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'template_id' => 'required|exists:templates,id',
            'is_public' => 'boolean'
        ]);

        $portfolio = auth()->user()->portfolios()->create([
            'name' => $validated['name'],
            'template_id' => $validated['template_id'],
            'is_public' => $request->boolean('is_public', false)
        ]);

        return redirect()->route('portfolios.edit', $portfolio)
            ->with('success', 'Portfolio created successfully.');
    }

    public function edit(Portfolio $portfolio)
    {
        $this->authorize('update', $portfolio);
        return view('portfolios.edit', compact('portfolio'));
    }

    public function update(Request $request, Portfolio $portfolio)
    {
        $this->authorize('update', $portfolio);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'is_public' => 'boolean'
        ]);

        $portfolio->update($validated);

        return redirect()->route('portfolios.index')
            ->with('success', 'Portfolio updated successfully.');
    }

    public function destroy(Portfolio $portfolio)
    {
        $this->authorize('delete', $portfolio);
        
        // Delete associated files if any
        if (!empty($portfolio->projects)) {
            foreach ($portfolio->projects as $project) {
                if (!empty($project['image'])) {
                    Storage::delete(str_replace('/storage/', 'public/', $project['image']));
                }
            }
        }

        $portfolio->delete();
        
        return redirect()->route('portfolios.index')
            ->with('success', 'Portfolio deleted successfully.');
    }

    public function download(Portfolio $portfolio)
    {
        $this->authorize('download', $portfolio);
        
        try {
            $service = new PortfolioDownloadService($portfolio);
            $zipPath = $service->generate();
            
            return response()->download($zipPath, $portfolio->name . '.zip')->deleteFileAfterSend();
        } catch (Exception $e) {
            return back()->with('error', 'Failed to generate portfolio download. Please try again.');
        }
    }

    public function preview(Portfolio $portfolio)
    {
        $this->authorize('view', $portfolio);
        return view('portfolios.preview', compact('portfolio'));
    }

    public function show(Portfolio $portfolio)
    {
        if (!$portfolio->is_public) {
            abort(404);
        }
        return view('portfolios.preview', compact('portfolio'));
    }

    public function bulkDelete(Request $request)
    {
        $portfolios = Portfolio::whereIn('id', $request->ids)->where('user_id', auth()->id())->get();
        
        foreach ($portfolios as $portfolio) {
            $this->authorize('delete', $portfolio);
            
            // Delete associated files if any
            if (!empty($portfolio->projects)) {
                foreach ($portfolio->projects as $project) {
                    if (!empty($project['image'])) {
                        Storage::delete(str_replace('/storage/', 'public/', $project['image']));
                    }
                }
            }

            $portfolio->delete();
        }

        return response()->json(['message' => 'Portfolios deleted successfully.']);
    }

    public function search(Request $request)
    {
        $query = $request->get('q');
        $portfolios = auth()->user()->portfolios()
            ->where('name', 'like', "%{$query}%")
            ->orWhere('personal_info->title', 'like', "%{$query}%")
            ->latest()
            ->paginate(10);

        return view('portfolios.index', compact('portfolios'));
    }

    public function duplicate(Portfolio $portfolio)
    {
        $this->authorize('view', $portfolio);

        $newPortfolio = $portfolio->replicate();
        $newPortfolio->name = $portfolio->name . ' (Copy)';
        $newPortfolio->save();

        // Duplicate project images if any
        if (!empty($portfolio->projects)) {
            $projects = $portfolio->projects;
            foreach ($projects as &$project) {
                if (!empty($project['image'])) {
                    $oldPath = str_replace('/storage/', 'public/', $project['image']);
                    $newPath = 'public/projects/' . uniqid() . '_' . basename($project['image']);
                    if (Storage::exists($oldPath)) {
                        Storage::copy($oldPath, $newPath);
                        $project['image'] = Storage::url($newPath);
                    }
                }
            }
            $newPortfolio->projects = $projects;
            $newPortfolio->save();
        }

        return redirect()->route('portfolios.index')
            ->with('success', 'Portfolio duplicated successfully.');
    }
} 