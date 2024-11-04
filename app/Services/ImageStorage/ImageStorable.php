<?php

declare(strict_types=1);

namespace WolfShop\Services\ImageStorage;

use Illuminate\Http\UploadedFile;

interface ImageStorable
{
    public function store(UploadedFile $file, string $path = ''): string;
}
