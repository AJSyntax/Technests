<?php

namespace App\Http\Controllers;

use App\Models\Portfolio;
use App\Models\Template;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = auth()->user();
        $portfolios = $user->portfolios()->latest()->paginate(10);
        $templates = Template::where('is_premium', false)->get();
        $premiumTemplates = Template::where('is_premium', true)->get();

        return view('dashboard', compact('portfolios', 'templates', 'premiumTemplates'));
    }
} 