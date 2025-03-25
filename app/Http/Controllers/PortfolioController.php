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
        $portfolios = auth()->user()->portfolios()->latest()->paginate(10);
        return view('portfolios.index', compact('portfolios'));
    }

    public function create()
    {
        return view('portfolios.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'template_id' => 'required|exists:templates,id',
            'personal_info' => 'required|array',
            'skills' => 'required|array',
            'experience' => 'required|array',
            'projects' => 'required|array',
            'education' => 'required|array',
            'certifications' => 'required|array',
        ]);

        $portfolio = Auth::user()->portfolios()->create($validated);

        return redirect()->route('portfolios.edit', $portfolio)
            ->with('success', 'Portfolio created successfully!');
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
            'template_id' => 'required|exists:templates,id',
            'personal_info' => 'required|array',
            'skills' => 'required|array',
            'experience' => 'required|array',
            'projects' => 'required|array',
            'education' => 'required|array',
            'certifications' => 'required|array',
        ]);

        $portfolio->update($validated);

        return redirect()->back()->with('success', 'Portfolio updated successfully!');
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
        $this->authorize('view', $portfolio);
        
        $template = $portfolio->template;
        
        // Create a temporary directory
        $tempDir = storage_path('app/temp/' . uniqid());
        mkdir($tempDir, 0755, true);
        
        // Generate the portfolio HTML using the template
        $html = view('templates.render', [
            'portfolio' => $portfolio,
            'template' => $template
        ])->render();
        
        // Save the files
        file_put_contents($tempDir . '/index.html', $html);
        file_put_contents($tempDir . '/style.css', $template->css_template);
        
        // Create ZIP archive
        $zipPath = storage_path('app/temp/' . $portfolio->name . '.zip');
        $zip = new ZipArchive();
        $zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE);
        
        $files = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($tempDir),
            \RecursiveIteratorIterator::LEAVES_ONLY
        );
        
        foreach ($files as $file) {
            if (!$file->isDir()) {
                $filePath = $file->getRealPath();
                $relativePath = substr($filePath, strlen($tempDir) + 1);
                $zip->addFile($filePath, $relativePath);
            }
        }
        
        $zip->close();
        
        // Clean up temporary directory
        array_map('unlink', glob("$tempDir/*.*"));
        rmdir($tempDir);
        
        return response()->download($zipPath)->deleteFileAfterSend(true);
    }

    public function preview(Portfolio $portfolio)
    {
        $this->authorize('view', $portfolio);
        
        // Get the template
        $template = $portfolio->template;
        
        // Prepare the data for the template
        $data = [
            'portfolio' => $portfolio,
            'personal_info' => $portfolio->personal_info,
            'skills' => $portfolio->skills,
            'experience' => $portfolio->experience,
            'projects' => $portfolio->projects,
        ];

        // Return the template view with the portfolio data
        return view("templates.{$template->slug}.index", $data);
    }

    public function show(Portfolio $portfolio)
    {
        $this->authorize('view', $portfolio);
        return view('portfolios.show', compact('portfolio'));
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