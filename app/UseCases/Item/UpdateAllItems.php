<?php

declare(strict_types=1);

namespace WolfShop\UseCases\Item;

use WolfShop\Domains\Item\ItemRepositoryInterface;

final class UpdateAllItems
{
    private const DEFAULT_CHUNK_SIZE = 100;

    public function __construct(
        private readonly ItemRepositoryInterface $repository,
        private readonly UpdateItem $updateItem
    )
    {
        //
    }
    public function handle(?int $chunkSize): void
    {
        $chunkSize = $chunkSize ?? self::DEFAULT_CHUNK_SIZE;

        $this->repository->chunk($chunkSize, function ($items) {
            foreach ($items as $item) {
                $this->updateItem->handle($item);
            }
        });
    }
}
