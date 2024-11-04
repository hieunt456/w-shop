<?php

declare(strict_types=1);

namespace WolfShop\UseCases\Item;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\UploadedFile;
use WolfShop\Domains\Item\Item;
use WolfShop\Domains\Item\ItemRepositoryInterface;
use WolfShop\Services\ImageStorage\ImageStorable;

final class UploadItemImage
{
    public function __construct(
        private readonly ItemRepositoryInterface $repository,
        private readonly ImageStorable $imageStorage
    )
    {
        //
    }

    public function handle(Item $item, UploadedFile $image): void
    {
        $imageUrl = $this->imageStorage->store($image);

        $item->setImgUrl($imageUrl);

        $this->repository->update($item);
    }
}
