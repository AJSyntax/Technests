<?php

namespace App\Http\Controllers;

use App\Models\Portfolio;
use Illuminate\Http\Request;

class PublicPortfolioController extends Controller
{
    public function show(Portfolio $portfolio)
    {
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
} 