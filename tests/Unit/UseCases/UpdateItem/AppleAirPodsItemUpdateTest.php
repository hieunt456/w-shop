<?php

declare(strict_types=1);

namespace Tests\Unit\UseCases\UpdateItem;

use Tests\TestCase;
use WolfShop\Domains\Item\Item;
use WolfShop\Domains\Item\ItemQuality;
use WolfShop\Domains\Item\Strategies\ItemUpdate\AppleAirPodsItemUpdate;

class AppleAirPodsItemUpdateTest extends TestCase
{
    public function testUpdateIncreasesQualityAndDecreasesSellIn(): void
    {
        $item = new Item('Apple AirPods', 10, 20);
        $updateStrategy = new AppleAirPodsItemUpdate();

        $updateStrategy->update($item);

        $this->assertEquals(9, $item->sellIn);
        $this->assertEquals(21, $item->quality);
    }

    public function testUpdateDoesNotExceedMaxQuality(): void
    {
        $item = new Item('Apple AirPods', 10, ItemQuality::MAX_VALUE);
        $updateStrategy = new AppleAirPodsItemUpdate();

        $updateStrategy->update($item);

        $this->assertEquals(ItemQuality::MAX_VALUE, $item->quality);
    }
}
