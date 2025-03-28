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
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

// Authentication routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Template routes (public)
Route::get('/templates', [TemplateController::class, 'index'])->name('templates.index');
Route::get('/templates/{template}', [TemplateController::class, 'show'])->name('templates.show');

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

    // Portfolio routes
    Route::resource('portfolios', PortfolioController::class)->except(['show']);
    Route::get('/portfolios/{portfolio}/preview', [PortfolioController::class, 'preview'])->name('portfolios.preview');
    Route::get('/portfolios/{portfolio}/download', [PortfolioController::class, 'download'])->name('portfolios.download');
    Route::post('/portfolios/{portfolio}/duplicate', [PortfolioController::class, 'duplicate'])->name('portfolios.duplicate');

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

    // Template purchase routes
    Route::get('/templates/{template}/purchase', [TemplateController::class, 'purchase'])->name('templates.purchase');
    Route::post('/templates/{template}/purchase', [TemplateController::class, 'processPurchase'])->name('templates.process-purchase');

    // Admin routes
    Route::middleware(['admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        
        // Template management
        Route::get('/templates', [AdminController::class, 'templates'])->name('templates.index');
        Route::get('/templates/create', [AdminController::class, 'createTemplate'])->name('templates.create');
        Route::post('/templates', [AdminController::class, 'storeTemplate'])->name('templates.store');
        Route::get('/templates/{template}/edit', [AdminController::class, 'editTemplate'])->name('templates.edit');
        Route::put('/templates/{template}', [AdminController::class, 'updateTemplate'])->name('templates.update');
        Route::delete('/templates/{template}', [AdminController::class, 'destroyTemplate'])->name('templates.destroy');

        // User management
        Route::get('/users', [AdminController::class, 'users'])->name('users.index');
        Route::get('/users/{user}/edit', [AdminController::class, 'editUser'])->name('users.edit');
        Route::put('/users/{user}', [AdminController::class, 'updateUser'])->name('users.update');
        Route::delete('/users/{user}', [AdminController::class, 'destroyUser'])->name('users.destroy');

        // Analytics
        Route::get('/analytics', [AdminController::class, 'analytics'])->name('analytics');
        Route::get('/analytics/downloads', [AdminController::class, 'downloadAnalytics'])->name('analytics.downloads');
        Route::get('/analytics/purchases', [AdminController::class, 'purchaseAnalytics'])->name('analytics.purchases');
    });
});

// Public portfolio routes
Route::get('/p/{portfolio}', [PublicPortfolioController::class, 'show'])->name('public.portfolios.show');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
