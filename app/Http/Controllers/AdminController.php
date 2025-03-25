<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Portfolio;
use App\Models\Template;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function dashboard()
    {
        $stats = [
            'total_users' => User::count(),
            'total_portfolios' => Portfolio::count(),
            'total_templates' => Template::count(),
            'latest_activities' => DB::table('activity_log')
                ->latest()
                ->take(10)
                ->get(),
        ];

        return view('admin.dashboard', compact('stats'));
    }

    public function users()
    {
        $users = User::withCount('portfolios')
            ->latest()
            ->paginate(20);

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
} 