<?php

declare(strict_types=1);

namespace Tests\Unit\UseCases\FindItemByName;

use Tests\TestCase;
use WolfShop\Domains\Item\Item;
use WolfShop\Domains\Item\ItemRepositoryInterface;
use WolfShop\UseCases\Item\FindItemByName;

class FindItemByNameTest extends TestCase
{
    public function testHandleReturnsItemWhenFound(): void
    {
        $itemName = 'Sample Item';
        $item = $this->createMock(Item::class);

        $repository = $this->createMock(ItemRepositoryInterface::class);

        $repository->expects($this->once())
            ->method('getByName')
            ->with($itemName)
            ->willReturn($item);

        $findItemByName = new FindItemByName($repository);

        $result = $findItemByName->handle($itemName);

        $this->assertSame($item, $result);
    }

    public function testHandleReturnsNullWhenItemNotFound(): void
    {
        $itemName = 'Nonexistent Item';

        $repository = $this->createMock(ItemRepositoryInterface::class);

        $repository->expects($this->once())
            ->method('getByName')
            ->with($itemName)
            ->willReturn(null);

        $findItemByName = new FindItemByName($repository);

        $result = $findItemByName->handle($itemName);

        $this->assertNull($result);
    }
}
