<?php

namespace App\Http\Controllers;

use App\Models\Template;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TemplateController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $templates = Template::where('is_premium', false)->get();
        $premiumTemplates = Template::where('is_premium', true)->get();
        return view('templates.index', compact('templates', 'premiumTemplates'));
    }

    public function show(Template $template)
    {
        // Create sample data for template preview
        $portfolio = [
            'name' => 'John Doe',
            'title' => 'Full Stack Developer',
            'bio' => 'A passionate web developer with 5 years of experience in creating beautiful and functional websites.',
            'profile_picture' => asset('images/default-avatar.png'),
            'github_username' => 'johndoe',
            'linkedin_url' => 'https://linkedin.com/in/johndoe',
            'projects' => [
                [
                    'name' => 'E-commerce Platform',
                    'description' => 'A full-featured e-commerce platform built with Laravel and Vue.js',
                    'image' => asset('images/project1.jpg'),
                    'url' => '#'
                ],
                [
                    'name' => 'Task Management App',
                    'description' => 'A real-time task management application using Laravel and Livewire',
                    'image' => asset('images/project2.jpg'),
                    'url' => '#'
                ],
                [
                    'name' => 'Portfolio Builder',
                    'description' => 'A dynamic portfolio builder for developers and creatives',
                    'image' => asset('images/project3.jpg'),
                    'url' => '#'
                ]
            ],
            'current_year' => date('Y')
        ];

        return view('templates.show', compact('template', 'portfolio'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', Template::class);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'thumbnail_url' => 'required|url',
            'is_premium' => 'required|boolean',
            'price' => 'required_if:is_premium,true|numeric|min:0',
            'html_template' => 'required|string',
            'css_template' => 'required|string',
        ]);

        Template::create($validated);

        return redirect()->route('admin.templates.index')
            ->with('success', 'Template created successfully!');
    }

    public function edit(Template $template)
    {
        $this->authorize('update', $template);
        return view('templates.edit', compact('template'));
    }

    public function update(Request $request, Template $template)
    {
        $this->authorize('update', $template);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'thumbnail_url' => 'required|url',
            'is_premium' => 'required|boolean',
            'price' => 'required_if:is_premium,true|numeric|min:0',
            'html_template' => 'required|string',
            'css_template' => 'required|string',
        ]);

        $template->update($validated);

        return redirect()->route('admin.templates.index')
            ->with('success', 'Template updated successfully!');
    }

    public function destroy(Template $template)
    {
        $this->authorize('delete', $template);
        $template->delete();
        return redirect()->route('admin.templates.index')
            ->with('success', 'Template deleted successfully!');
    }

    public function purchase(Template $template)
    {
        if ($template->is_premium) {
            return view('templates.purchase', compact('template'));
        }

        return redirect()->back()->with('error', 'This template is not available for purchase.');
    }

    public function processPurchase(Request $request, Template $template)
    {
        if (!$template->is_premium) {
            return redirect()->back()->with('error', 'This template is not available for purchase.');
        }

        // Check if user already purchased this template
        if (Auth::user()->purchases()->where('template_id', $template->id)->where('status', 'completed')->exists()) {
            return redirect()->back()->with('error', 'You have already purchased this template.');
        }

        // Create a new purchase record
        $purchase = Auth::user()->purchases()->create([
            'template_id' => $template->id,
            'amount' => $template->price,
            'status' => 'pending',
            'payment_method' => $request->payment_method,
            'transaction_id' => uniqid('TXN_'),
        ]);

        // Here you would typically integrate with a payment gateway
        // For now, we'll just mark it as completed
        $purchase->update(['status' => 'completed']);

        return redirect()->route('portfolios.create')
            ->with('success', 'Template purchased successfully! You can now use it to create a portfolio.');
    }
} 