<?php

namespace App\Http\Controllers;

use App\Models\Template;
use Illuminate\Http\Request;

class TemplateController extends Controller
{
    public function show(Template $template)
    {
        return view('templates.show', compact('template'));
    }
} 