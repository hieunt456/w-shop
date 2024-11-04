<?php

declare(strict_types=1);

namespace Tests\Unit\UseCases\UpdateItem;

use Tests\TestCase;
use WolfShop\Domains\Item\Item;
use WolfShop\Domains\Item\Strategies\ItemUpdate\NormalItemUpdate;

class NormalItemUpdateTest extends TestCase
{
    public function testUpdateDecreasesSellInAndQuality(): void
    {
        $item = new Item('Normal Item', 10, 20);
        $updateStrategy = new NormalItemUpdate();

        $updateStrategy->update($item);

        $this->assertEquals(9, $item->sellIn);
        $this->assertEquals(19, $item->quality);
    }

    public function testUpdateDoublesQualityDecreaseAfterExpiration(): void
    {
        $item = new Item('Expired Item', 0, 20);
        $updateStrategy = new NormalItemUpdate();

        $updateStrategy->update($item);

        $this->assertEquals(-1, $item->sellIn);
        $this->assertEquals(18, $item->quality);
    }
}
