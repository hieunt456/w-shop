<?php

declare(strict_types=1);

namespace Tests\Unit\Services\ImageStorage;

use Cloudinary\Api\Upload\UploadApi;
use Cloudinary\Cloudinary;
use Cloudinary\Configuration\Configuration;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Config;
use Tests\TestCase;
use WolfShop\Services\ImageStorage\CloudinaryStorage;

class CloudinaryStorageTest extends TestCase
{
    public function testConstructorThrowsExceptionWhenCloudinaryUrlNotSet(): void
    {
        Config::set('cloudinary.url', null);

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Cloudinary url is not set.');

        $cloudinaryMock = $this->createMock(Cloudinary::class);
        new CloudinaryStorage($cloudinaryMock);
    }

    public function testStoreUploadsFileAndReturnsUrl(): void
    {
        Config::set('cloudinary.url', 'cloudinary://api_key:api_secret@cloud_name');

        $file = $this->createMock(UploadedFile::class);
        $file->method('path')->willReturn('/path/to/file');

        $expectedUrl = 'https://example.com/secure_url.jpg';

        $uploadApiMock = $this->createMock(UploadApi::class);
        $uploadApiMock->expects($this->once())
            ->method('upload')
            ->with('/path/to/file')
            ->willReturn(['secure_url' => $expectedUrl]);

        $cloudinaryMock = $this->createMock(Cloudinary::class);
        $cloudinaryMock->method('uploadApi')->willReturn($uploadApiMock);

        $configurationMock = $this->createMock(Configuration::class);
        $cloudinaryMock->configuration = $configurationMock;

        $storage = new CloudinaryStorage($cloudinaryMock);

        $result = $storage->store($file);

        $this->assertEquals($expectedUrl, $result);
    }
}
