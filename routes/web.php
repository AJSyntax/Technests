<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Dashboard;
use App\Livewire\PortfolioEditor;
use App\Livewire\TemplateGallery;
use App\Livewire\GithubImport;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\ExperienceController;
use App\Http\Controllers\EducationController;
use App\Http\Controllers\CertificationController;
use App\Http\Controllers\TemplateController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use App\Models\Template;
use App\Models\Activity;
use App\Http\Controllers\TemplatePreviewController;

Route::view('/', 'welcome')->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard', [
            'portfolios' => Auth::user()->portfolios()->paginate(9),
            'recentActivity' => Activity::where('user_id', Auth::id())
                ->latest()
                ->take(5)
                ->get()
        ]);
    })->name('dashboard');

    // Profile Routes
    Route::prefix('profile')->name('profile.')->middleware('auth')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
    });

    // Template Routes
    Route::prefix('templates')->name('templates.')->group(function () {
        Route::get('/', function () {
            return view('templates.index', [
                'templates' => Template::paginate(9)
            ]);
        })->name('index');

        Route::get('/{template}', [TemplateController::class, 'show'])->name('show');
    });

    // Portfolio Routes
    Route::middleware(['auth'])->group(function () {
        Route::get('/portfolios', [PortfolioController::class, 'index'])->name('portfolio.index');
        Route::get('/portfolios/create', [PortfolioController::class, 'create'])->name('portfolio.create');
        Route::post('/portfolios', [PortfolioController::class, 'store'])->name('portfolio.store');
        Route::get('/portfolios/{portfolio}/edit', [PortfolioController::class, 'edit'])->name('portfolio.edit');
        Route::put('/portfolios/{portfolio}', [PortfolioController::class, 'update'])->name('portfolio.update');
        Route::delete('/portfolios/{portfolio}', [PortfolioController::class, 'destroy'])->name('portfolio.destroy');
        Route::post('/portfolios/bulk-delete', [PortfolioController::class, 'bulkDelete'])->name('portfolio.bulk-delete');
        Route::post('/portfolios/{portfolio}/duplicate', [PortfolioController::class, 'duplicate'])->name('portfolio.duplicate');
        Route::get('/portfolios/search', [PortfolioController::class, 'search'])->name('portfolio.search');
        Route::get('/portfolios/{portfolio}/preview', [PortfolioController::class, 'preview'])->name('portfolio.preview');

        // Experience Routes
        Route::prefix('{portfolio}/experience')->name('experience.')->group(function () {
            Route::get('/', [ExperienceController::class, 'index'])->name('index');
            Route::post('/', [ExperienceController::class, 'store'])->name('store');
            Route::put('/{experience}', [ExperienceController::class, 'update'])->name('update');
            Route::delete('/{experience}', [ExperienceController::class, 'destroy'])->name('destroy');
            Route::post('/reorder', [ExperienceController::class, 'reorder'])->name('reorder');
            Route::post('/bulk-delete', [ExperienceController::class, 'bulkDelete'])->name('bulk-delete');
            Route::get('/search', [ExperienceController::class, 'search'])->name('search');
        });

        // Education Routes
        Route::prefix('{portfolio}/education')->name('education.')->group(function () {
            Route::get('/', [EducationController::class, 'index'])->name('index');
            Route::post('/', [EducationController::class, 'store'])->name('store');
            Route::put('/{education}', [EducationController::class, 'update'])->name('update');
            Route::delete('/{education}', [EducationController::class, 'destroy'])->name('destroy');
            Route::post('/reorder', [EducationController::class, 'reorder'])->name('reorder');
            Route::post('/bulk-delete', [EducationController::class, 'bulkDelete'])->name('bulk-delete');
            Route::get('/search', [EducationController::class, 'search'])->name('search');
        });

        // Certification Routes
        Route::prefix('{portfolio}/certification')->name('certification.')->group(function () {
            Route::get('/', [CertificationController::class, 'index'])->name('index');
            Route::post('/', [CertificationController::class, 'store'])->name('store');
            Route::put('/{certification}', [CertificationController::class, 'update'])->name('update');
            Route::delete('/{certification}', [CertificationController::class, 'destroy'])->name('destroy');
            Route::post('/reorder', [CertificationController::class, 'reorder'])->name('reorder');
            Route::post('/bulk-delete', [CertificationController::class, 'bulkDelete'])->name('bulk-delete');
            Route::get('/search', [CertificationController::class, 'search'])->name('search');
        });
    });

    Route::get('/github-import', GithubImport::class)->name('github.import');
});

// Public portfolio routes
Route::get('/p/{portfolio}', [PortfolioController::class, 'show'])->name('portfolio.show');

Route::get('/templates/{templateSlug}/preview', [TemplatePreviewController::class, 'show'])
    ->name('templates.preview');

require __DIR__.'/auth.php';
