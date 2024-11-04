<?php

declare(strict_types=1);

namespace Tests\Unit\UseCases\UploadItemImage;

use Illuminate\Http\UploadedFile;
use Tests\TestCase;
use WolfShop\Domains\Item\Item;
use WolfShop\Domains\Item\ItemRepositoryInterface;
use WolfShop\Services\ImageStorage\ImageStorable;
use WolfShop\UseCases\Item\UploadItemImage;

class UploadItemImageTest extends TestCase
{
    public function testHandleStoresImageSetsUrlAndUpdatesItem(): void
    {
        $item = $this->createMock(Item::class);
        $image = $this->createMock(UploadedFile::class);
        $imageUrl = 'http://example.com/image.jpg';

        $repository = $this->createMock(ItemRepositoryInterface::class);
        $imageStorage = $this->createMock(ImageStorable::class);

        $imageStorage->expects($this->once())
            ->method('store')
            ->with($image)
            ->willReturn($imageUrl);

        $item->expects($this->once())
            ->method('setImgUrl')
            ->with($imageUrl);

        $repository->expects($this->once())
            ->method('update')
            ->with($item);

        $uploadItemImage = new UploadItemImage($repository, $imageStorage);

        $uploadItemImage->handle($item, $image);
    }
}
