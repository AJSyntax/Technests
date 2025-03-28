<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Portfolio;
use App\Models\Template;
use App\Models\Purchase;
use App\Models\Download;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function dashboard()
    {
        $stats = [
            'users_count' => User::count(),
            'templates_count' => Template::count(),
            'purchases_count' => Purchase::count(),
            'downloads_count' => Download::count(),
            'revenue' => Purchase::sum('amount'),
            'recent_users' => User::latest()->take(5)->get(),
            'recent_purchases' => Purchase::with('user', 'template')->latest()->take(5)->get(),
        ];

        return view('admin.dashboard', compact('stats'));
    }

    public function users()
    {
        $users = User::withCount(['portfolios', 'purchases'])
            ->with('roles')
            ->latest()
            ->paginate(10);
            
        return view('admin.users.index', compact('users'));
    }

    public function userShow(User $user)
    {
        $user->load(['portfolios' => function ($query) {
            $query->latest();
        }]);

        return view('admin.users.show', compact('user'));
    }

    public function userToggleStatus(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot disable your own account.');
        }

        $user->is_active = !$user->is_active;
        $user->save();

        $status = $user->is_active ? 'activated' : 'deactivated';
        return back()->with('success', "User account {$status} successfully.");
    }

    public function activityLog()
    {
        $activities = DB::table('activity_log')
            ->latest()
            ->paginate(50);

        return view('admin.activity-log', compact('activities'));
    }

    public function downloadLog()
    {
        $downloads = DB::table('portfolio_downloads')
            ->join('portfolios', 'portfolio_downloads.portfolio_id', '=', 'portfolios.id')
            ->join('users', 'portfolios.user_id', '=', 'users.id')
            ->select('portfolio_downloads.*', 'portfolios.name as portfolio_name', 'users.name as user_name')
            ->latest()
            ->paginate(50);

        return view('admin.downloads', compact('downloads'));
    }

    // Template Management
    public function templates()
    {
        $templates = Template::withCount(['portfolios', 'purchases'])->latest()->paginate(10);
        return view('admin.templates.index', compact('templates'));
    }

    public function createTemplate()
    {
        return view('admin.templates.create');
    }

    public function storeTemplate(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'thumbnail' => 'required|image|max:2048',
            'price' => 'required|numeric|min:0',
            'is_premium' => 'boolean',
            'html_template' => 'required|string',
            'css_template' => 'required|string',
        ]);

        if ($request->hasFile('thumbnail')) {
            $path = $request->file('thumbnail')->store('templates', 'public');
            $validated['thumbnail_url'] = Storage::url($path);
        }

        Template::create($validated);

        return redirect()->route('admin.templates.index')
            ->with('success', 'Template created successfully.');
    }

    public function editTemplate(Template $template)
    {
        return view('admin.templates.edit', compact('template'));
    }

    public function updateTemplate(Request $request, Template $template)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'thumbnail' => 'nullable|image|max:2048',
            'price' => 'required|numeric|min:0',
            'is_premium' => 'boolean',
            'html_template' => 'required|string',
            'css_template' => 'required|string',
        ]);

        if ($request->hasFile('thumbnail')) {
            // Delete old thumbnail
            if ($template->thumbnail_url) {
                Storage::delete(str_replace('/storage/', 'public/', $template->thumbnail_url));
            }
            
            $path = $request->file('thumbnail')->store('templates', 'public');
            $validated['thumbnail_url'] = Storage::url($path);
        }

        $template->update($validated);

        return redirect()->route('admin.templates.index')
            ->with('success', 'Template updated successfully.');
    }

    public function destroyTemplate(Template $template)
    {
        if ($template->thumbnail_url) {
            Storage::delete(str_replace('/storage/', 'public/', $template->thumbnail_url));
        }

        $template->delete();

        return redirect()->route('admin.templates.index')
            ->with('success', 'Template deleted successfully.');
    }

    // User Management
    public function editUser(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function updateUser(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'roles' => 'required|array',
            'roles.*' => 'exists:roles,id'
        ]);

        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email']
        ]);

        $user->roles()->sync($validated['roles']);

        return redirect()->route('admin.users.index')
            ->with('success', 'User updated successfully.');
    }

    public function destroyUser(User $user)
    {
        if ($user->isAdmin()) {
            return back()->with('error', 'Cannot delete an admin user.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'User deleted successfully.');
    }

    // Analytics
    public function analytics()
    {
        $monthlyStats = Purchase::selectRaw('
            DATE_FORMAT(created_at, "%Y-%m") as month,
            COUNT(*) as total_purchases,
            SUM(amount) as total_revenue
        ')
        ->groupBy('month')
        ->orderBy('month', 'desc')
        ->take(12)
        ->get();

        $popularTemplates = Template::withCount('purchases')
            ->orderBy('purchases_count', 'desc')
            ->take(5)
            ->get();

        return view('admin.analytics.index', compact('monthlyStats', 'popularTemplates'));
    }

    public function downloadAnalytics()
    {
        $downloads = Download::with(['user', 'portfolio'])
            ->latest()
            ->paginate(20);

        return view('admin.analytics.downloads', compact('downloads'));
    }

    public function purchaseAnalytics()
    {
        $purchases = Purchase::with(['user', 'template'])
            ->latest()
            ->paginate(20);

        return view('admin.analytics.purchases', compact('purchases'));
    }
} 