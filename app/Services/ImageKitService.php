<?php

namespace App\Services;

use ImageKit\ImageKit;

class ImageKitService
{
    protected $imageKit;

    public function __construct()
    {
        $this->imageKit = new ImageKit(
            config('services.imagekit.public_key'),
            config('services.imagekit.private_key'),
            config('services.imagekit.endpoint')
        );
    }

    public function uploadImage($file, $folder = '')
    {
        $fileName = $file->hashName();
        $filePath = $folder ? $folder . '/' . $fileName : $fileName;

        $result = $this->imageKit->upload([
            'file' => base64_encode(file_get_contents($file->path())),
            'fileName' => $fileName,
            'folder' => $folder,
        ]);

        if (!empty($result->error)) {
            throw new \Exception($result->error->message);
        }

        return [
            'url' => $result->success->url,
            'path' => $filePath,
            'fileId' => $result->success->fileId
        ];
    }

    public function deleteImage($fileId)
    {
        if (!$fileId) {
            return;
        }

        $result = $this->imageKit->deleteFile($fileId);

        if (!empty($result->error)) {
            throw new \Exception($result->error->message);
        }

        return true;
    }
} 