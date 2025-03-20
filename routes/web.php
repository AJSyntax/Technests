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
use Illuminate\Support\Facades\Auth;
use App\Models\Template;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard', [
            'portfolios' => Auth::user()->portfolios()->paginate(9)
        ]);
    })->name('dashboard');

    Route::get('/templates', function () {
        return view('templates.index', [
            'templates' => Template::paginate(9)
        ]);
    })->name('templates');

    // Portfolio Routes
    Route::prefix('portfolio')->name('portfolio.')->group(function () {
        Route::get('/', [PortfolioController::class, 'index'])->name('index');
        Route::get('/create', [PortfolioController::class, 'create'])->name('create');
        Route::post('/store', [PortfolioController::class, 'store'])->name('store');
        Route::get('/{portfolio}/edit', [PortfolioController::class, 'edit'])->name('edit');
        Route::put('/{portfolio}', [PortfolioController::class, 'update'])->name('update');
        Route::get('/{portfolio}/preview', [PortfolioController::class, 'preview'])->name('preview');
        Route::delete('/{portfolio}', [PortfolioController::class, 'destroy'])->name('destroy');
        Route::post('/bulk-delete', [PortfolioController::class, 'bulkDelete'])->name('bulk-delete');
        Route::get('/search', [PortfolioController::class, 'search'])->name('search');
        Route::post('/{portfolio}/duplicate', [PortfolioController::class, 'duplicate'])->name('duplicate');

        // Experience Routes
        Route::prefix('{portfolio}/experiences')->name('experiences.')->group(function () {
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
        Route::prefix('{portfolio}/certifications')->name('certifications.')->group(function () {
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

require __DIR__.'/auth.php';
