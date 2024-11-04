<?php

declare(strict_types=1);

namespace Tests\Unit\UseCases\GetAllItems;

use Tests\TestCase;
use WolfShop\Domains\Item\Item;
use WolfShop\Domains\Item\ItemRepositoryInterface;
use WolfShop\UseCases\Item\GetAllItems;

class GetAllItemsTest extends TestCase
{
    public function testHandleReturnsAllItems(): void
    {
        $items = [
            $this->createMock(Item::class),
            $this->createMock(Item::class),
        ];

        $repository = $this->createMock(ItemRepositoryInterface::class);
        $repository->expects($this->once())
            ->method('getAll')
            ->willReturn($items);

        $getAllItems = new GetAllItems($repository);

        $result = $getAllItems->handle();

        $this->assertSame($items, $result);
    }
}
