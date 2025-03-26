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
use App\Http\Controllers\AdminController;
use App\Http\Controllers\GithubController;
use App\Http\Controllers\PublicPortfolioController;

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
        Route::get('/portfolios', [PortfolioController::class, 'index'])->name('portfolios.index');
        Route::get('/portfolios/create', [PortfolioController::class, 'create'])->name('portfolios.create');
        Route::post('/portfolios', [PortfolioController::class, 'store'])->name('portfolios.store');
        Route::get('/portfolios/{portfolio}', [PortfolioController::class, 'show'])->name('portfolios.show');
        Route::get('/portfolios/{portfolio}/edit', [PortfolioController::class, 'edit'])->name('portfolios.edit');
        Route::put('/portfolios/{portfolio}', [PortfolioController::class, 'update'])->name('portfolios.update');
        Route::delete('/portfolios/{portfolio}', [PortfolioController::class, 'destroy'])->name('portfolios.destroy');
        Route::post('/portfolios/bulk-delete', [PortfolioController::class, 'bulkDelete'])->name('portfolios.bulk-delete');
        Route::post('/portfolios/{portfolio}/duplicate', [PortfolioController::class, 'duplicate'])->name('portfolios.duplicate');
        Route::get('/portfolios/search', [PortfolioController::class, 'search'])->name('portfolios.search');
        Route::get('/portfolios/{portfolio}/preview', [PortfolioController::class, 'preview'])->name('portfolios.preview');

        // Experience Routes
        Route::prefix('{portfolio}/experience')->name('experience.')->group(function () {
            Route::get('/', [ExperienceController::class, 'index'])->name('experience.index');
            Route::post('/', [ExperienceController::class, 'store'])->name('experience.store');
            Route::put('/{experience}', [ExperienceController::class, 'update'])->name('experience.update');
            Route::delete('/{experience}', [ExperienceController::class, 'destroy'])->name('experience.destroy');
            Route::post('/reorder', [ExperienceController::class, 'reorder'])->name('experience.reorder');
            Route::post('/bulk-delete', [ExperienceController::class, 'bulkDelete'])->name('experience.bulk-delete');
            Route::get('/search', [ExperienceController::class, 'search'])->name('experience.search');
        });

        // Education Routes
        Route::prefix('{portfolio}/education')->name('education.')->group(function () {
            Route::get('/', [EducationController::class, 'index'])->name('education.index');
            Route::post('/', [EducationController::class, 'store'])->name('education.store');
            Route::put('/{education}', [EducationController::class, 'update'])->name('education.update');
            Route::delete('/{education}', [EducationController::class, 'destroy'])->name('education.destroy');
            Route::post('/reorder', [EducationController::class, 'reorder'])->name('education.reorder');
            Route::post('/bulk-delete', [EducationController::class, 'bulkDelete'])->name('education.bulk-delete');
            Route::get('/search', [EducationController::class, 'search'])->name('education.search');
        });

        // Certification Routes
        Route::prefix('{portfolio}/certification')->name('certification.')->group(function () {
            Route::get('/', [CertificationController::class, 'index'])->name('certification.index');
            Route::post('/', [CertificationController::class, 'store'])->name('certification.store');
            Route::put('/{certification}', [CertificationController::class, 'update'])->name('certification.update');
            Route::delete('/{certification}', [CertificationController::class, 'destroy'])->name('certification.destroy');
            Route::post('/reorder', [CertificationController::class, 'reorder'])->name('certification.reorder');
            Route::post('/bulk-delete', [CertificationController::class, 'bulkDelete'])->name('certification.bulk-delete');
            Route::get('/search', [CertificationController::class, 'search'])->name('certification.search');
        });
    });

    Route::get('/github-import', GithubImport::class)->name('github.import');
});

// Public portfolio routes
Route::get('/p/{portfolio}', [PublicPortfolioController::class, 'show'])->name('public.portfolios.show');

Route::get('/templates/{templateSlug}/preview', [TemplatePreviewController::class, 'show'])
    ->name('templates.preview');

// Admin routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('users', [AdminController::class, 'users'])->name('users.index');
    Route::get('users/{user}', [AdminController::class, 'userShow'])->name('users.show');
    Route::post('users/{user}/toggle-status', [AdminController::class, 'userToggleStatus'])
        ->name('users.toggle-status');
    Route::get('activity-log', [AdminController::class, 'activityLog'])->name('activity-log');
    Route::get('downloads', [AdminController::class, 'downloadLog'])->name('downloads');

    // Admin template management
    Route::resource('templates', TemplateController::class)->except(['index', 'show']);
});

require __DIR__.'/auth.php';
