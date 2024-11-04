<?php

declare(strict_types=1);

namespace Tests\Unit\UseCases\UpdateItem;

use Tests\TestCase;
use WolfShop\Domains\Item\Item;
use WolfShop\Domains\Item\Strategies\ItemUpdate\LegendaryItemUpdate;

class LegendaryItemUpdateTest extends TestCase
{
    public function testUpdateDoesNotChangeQuality(): void
    {
        $item = new Item('Legendary Item', 10, 80);
        $updateStrategy = new LegendaryItemUpdate();

        $updateStrategy->update($item);

        $this->assertEquals(80, $item->quality);
    }
}
