<?php

namespace App\Services;

use App\Models\Portfolio;
use Illuminate\Support\Facades\Storage;
use ZipArchive;
use Exception;

class PortfolioDownloadService
{
    protected $portfolio;
    protected $template;
    protected $tempDir;
    protected $assetsDir;

    public function __construct(Portfolio $portfolio)
    {
        $this->portfolio = $portfolio;
        $this->template = $portfolio->template;
        $this->tempDir = storage_path('app/temp/' . uniqid());
        $this->assetsDir = $this->tempDir . '/assets';
    }

    public function generate()
    {
        try {
            $this->createDirectories();
            $this->generateHtml();
            $this->generateAssets();
            $zipPath = $this->createZip();
            $this->cleanup();

            return $zipPath;
        } catch (Exception $e) {
            $this->cleanup();
            throw $e;
        }
    }

    protected function createDirectories()
    {
        $directories = [
            $this->tempDir,
            $this->assetsDir,
            $this->assetsDir . '/css',
            $this->assetsDir . '/js',
            $this->assetsDir . '/images'
        ];

        foreach ($directories as $dir) {
            if (!file_exists($dir)) {
                mkdir($dir, 0755, true);
            }
        }
    }

    protected function generateHtml()
    {
        $view = view('templates.' . $this->template->name . '.index', [
            'portfolio' => $this->portfolio,
            'personalInfo' => $this->portfolio->personalInfo,
            'skills' => $this->portfolio->skills,
            'projects' => $this->portfolio->projects,
            'education' => $this->portfolio->education,
            'certifications' => $this->portfolio->certifications
        ])->render();

        // Update asset paths in the HTML
        $view = str_replace(
            ['assets/css/', 'assets/js/', 'assets/images/'],
            ['css/', 'js/', 'images/'],
            $view
        );

        file_put_contents($this->tempDir . '/index.html', $view);
    }

    protected function generateAssets()
    {
        // Copy template CSS
        $cssPath = resource_path('views/templates/' . $this->template->name . '/assets/css/style.css');
        if (file_exists($cssPath)) {
            copy($cssPath, $this->assetsDir . '/css/style.css');
        }

        // Copy template JS
        $jsPath = resource_path('views/templates/' . $this->template->name . '/assets/js/main.js');
        if (file_exists($jsPath)) {
            copy($jsPath, $this->assetsDir . '/js/main.js');
        }

        // Copy profile picture
        if ($this->portfolio->personalInfo->profile_picture) {
            $this->copyImage(
                $this->portfolio->personalInfo->profile_picture,
                'profile-picture.jpg'
            );
        }

        // Copy project images
        foreach ($this->portfolio->projects as $project) {
            if ($project->image) {
                $this->copyImage(
                    $project->image,
                    'project-' . $project->id . '.jpg'
                );
            }
        }
    }

    protected function copyImage($path, $filename)
    {
        $sourcePath = storage_path('app/public/' . $path);
        if (file_exists($sourcePath)) {
            copy($sourcePath, $this->assetsDir . '/images/' . $filename);
        }
    }

    protected function createZip()
    {
        $zip = new ZipArchive();
        $zipPath = storage_path('app/public/downloads/' . $this->portfolio->id . '.zip');

        if (!file_exists(dirname($zipPath))) {
            mkdir(dirname($zipPath), 0755, true);
        }

        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === true) {
            $this->addFolderToZip($zip, $this->tempDir, '');
            $zip->close();
        }

        return $zipPath;
    }

    protected function addFolderToZip($zip, $folder, $relativePath)
    {
        $files = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($folder),
            \RecursiveIteratorIterator::LEAVES_ONLY
        );

        foreach ($files as $file) {
            if (!$file->isDir()) {
                $filePath = $file->getRealPath();
                $zip->addFile($filePath, $relativePath . substr($filePath, strlen($folder) + 1));
            }
        }
    }

    protected function cleanup()
    {
        if (file_exists($this->tempDir)) {
            $this->removeDirectory($this->tempDir);
        }
    }

    protected function removeDirectory($dir)
    {
        if (!file_exists($dir)) {
            return true;
        }

        if (!is_dir($dir)) {
            return unlink($dir);
        }

        foreach (scandir($dir) as $item) {
            if ($item == '.' || $item == '..') {
                continue;
            }

            if (!$this->removeDirectory($dir . DIRECTORY_SEPARATOR . $item)) {
                return false;
            }
        }

        return rmdir($dir);
    }
} 