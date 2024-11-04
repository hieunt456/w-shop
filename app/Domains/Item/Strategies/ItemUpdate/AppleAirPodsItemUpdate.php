<?php

declare(strict_types=1);

namespace WolfShop\Domains\Item\Strategies\ItemUpdate;

use WolfShop\Domains\Item\Item;
use WolfShop\Domains\Item\ItemQuality;

final class AppleAirPodsItemUpdate implements ItemUpdateStrategy
{
    private const DAILY_QUALITY_INCREASE = 1;

    public function update(Item $item): void
    {
        $item->sellIn--;

        $item->quality = min(ItemQuality::MAX_VALUE, $item->quality + self::DAILY_QUALITY_INCREASE);
    }
}
