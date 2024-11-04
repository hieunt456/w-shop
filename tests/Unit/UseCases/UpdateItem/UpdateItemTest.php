<?php

declare(strict_types=1);

namespace Tests\Unit\UseCases\UpdateItem;

use Tests\TestCase;
use WolfShop\Domains\Item\Item;
use WolfShop\Domains\Item\ItemRepositoryInterface;
use WolfShop\Domains\Item\Strategies\ItemUpdate\ItemUpdateStrategy;
use WolfShop\Domains\Item\Strategies\ItemUpdate\ItemUpdateStrategyFactory;
use WolfShop\UseCases\Item\UpdateItem;

class UpdateItemTest extends TestCase
{
    public function testHandleAppliesStrategyAndUpdatesItem(): void
    {
        $item = $this->createMock(Item::class);
        $mockStrategy = $this->createMock(ItemUpdateStrategy::class);
        $mockRepository = $this->createMock(ItemRepositoryInterface::class);
        $mockFactory = $this->createMock(ItemUpdateStrategyFactory::class);

        $mockFactory->expects($this->once())
            ->method('getStrategy')
            ->with($item)
            ->willReturn($mockStrategy);

        $mockStrategy->expects($this->once())
            ->method('update')
            ->with($item);

        $mockRepository->expects($this->once())
            ->method('update')
            ->with($item);

        $updateItem = new UpdateItem($mockRepository, $mockFactory);
        $updateItem->handle($item);
    }
}
