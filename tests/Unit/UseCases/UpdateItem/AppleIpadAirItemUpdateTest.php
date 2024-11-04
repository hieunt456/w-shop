<?php

declare(strict_types=1);

namespace Tests\Unit\UseCases\UpdateItem;

use Tests\TestCase;
use WolfShop\Domains\Item\Item;
use WolfShop\Domains\Item\ItemQuality;
use WolfShop\Domains\Item\Strategies\ItemUpdate\AppleIpadAirItemUpdate;

class AppleIpadAirItemUpdateTest extends TestCase
{
    public function testUpdateChangesQualityWithDifferentSellIns(): void
    {
        $item = new Item('Apple iPad Air', 15, 20);
        $updateStrategy = new AppleIpadAirItemUpdate();
        $updateStrategy->update($item);
        $this->assertEquals(21, $item->quality);

        $item->sellIn = 10;
        $updateStrategy->update($item);
        $this->assertEquals(23, $item->quality);

        $item->sellIn = 5;
        $updateStrategy->update($item);
        $this->assertEquals(26, $item->quality);

        $item->sellIn = 0;
        $updateStrategy->update($item);
        $this->assertEquals(ItemQuality::MIN_VALUE, $item->quality);
    }
}
