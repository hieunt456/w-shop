<?php

declare(strict_types=1);

namespace Tests\Unit\UseCases\CreateItem;

use Tests\TestCase;
use WolfShop\Domains\Item\Item;
use WolfShop\Domains\Item\ItemRepositoryInterface;
use WolfShop\Domains\Item\Strategies\ItemCreate\ItemCreateStrategy;
use WolfShop\Domains\Item\Strategies\ItemCreate\ItemCreateStrategyFactory;
use WolfShop\UseCases\Item\CreateItem;

class CreateItemTest extends TestCase
{
    public function testHandleCreatesAndSavesItem(): void
    {
        $attributes = [
            'name' => 'generic item',
            'sellIn' => 10,
            'quality' => 20,
        ];

        $mockStrategy = $this->createMock(ItemCreateStrategy::class);
        $mockItem = $this->createMock(Item::class);
        $mockRepository = $this->createMock(ItemRepositoryInterface::class);

        $mockStrategy->expects($this->once())
            ->method('create')
            ->with($attributes)
            ->willReturn($mockItem);

        $mockRepository->expects($this->once())
            ->method('save')
            ->with($mockItem);

        $mockFactory = $this->getMockBuilder(ItemCreateStrategyFactory::class)
            ->onlyMethods(['getStrategy'])
            ->getMock();

        $mockFactory->expects($this->once())
            ->method('getStrategy')
            ->with($attributes)
            ->willReturn($mockStrategy);

        $createItem = new CreateItem($mockRepository, $mockFactory);
        $createItem->handle($attributes);
    }
}
