<?php

declare(strict_types=1);

namespace Tests\Unit\UseCases\UploadAllItems;

use Tests\TestCase;
use WolfShop\Domains\Item\Item;
use WolfShop\Domains\Item\ItemRepositoryInterface;
use WolfShop\Domains\Item\Strategies\ItemUpdate\ItemUpdateStrategyFactory;
use WolfShop\UseCases\Item\UpdateAllItems;
use WolfShop\UseCases\Item\UpdateItem;

class UploadAllItemsTest extends TestCase
{
    public function testUpdateAllItemsHandlesItemsInChunks(): void
    {
        $mockRepository = $this->createMock(ItemRepositoryInterface::class);
        $mockFactory = $this->createMock(ItemUpdateStrategyFactory::class);
        $updateItem = new UpdateItem($mockRepository, $mockFactory);

        $item1 = new Item('Item 1', 10, 10);
        $item2 = new Item('Item 2', 5, 8);

        $mockRepository->expects($this->once())
            ->method('chunk')
            ->with(2)
            ->willReturnCallback(function ($chunkSize, $callback) use ($item1, $item2) {
                $callback([$item1, $item2]);
            });

        $updateAllItems = new UpdateAllItems($mockRepository, $updateItem);
        $updateAllItems->handle(2);
    }
}
