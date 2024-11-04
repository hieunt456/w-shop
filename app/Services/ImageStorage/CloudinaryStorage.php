<?php

declare(strict_types=1);

namespace WolfShop\Services\ImageStorage;

use Cloudinary\Cloudinary;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Config;

class CloudinaryStorage implements ImageStorable
{
    public function __construct(private readonly Cloudinary $cloudinary)
    {
        if (!$url = Config::get('cloudinary.url')) {
            throw new \RuntimeException('Cloudinary url is not set.');
        }

        $this->cloudinary->configuration->import($url);
    }

    public function store(UploadedFile $file, string $path = ''): string
    {
        $response = $this->cloudinary->uploadApi()->upload($file->path(), [
            'folder' => $path,
        ]);

        return $response['secure_url'];
    }
}
