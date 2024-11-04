<?php

declare(strict_types=1);

namespace WolfShop\Domains\Item\Strategies\ItemUpdate;

use WolfShop\Domains\Item\Item;
use WolfShop\Domains\Item\ItemQuality;
use WolfShop\Domains\Item\ItemSellIn;

final class ConjuredItemUpdate implements ItemUpdateStrategy
{
    private const DAILY_QUALITY_DECREASE_RATE = 2;

    public function update(Item $item): void
    {
        $item->sellIn--;

        $qualityDecrement = $item->sellIn < ItemSellIn::EXPIRATION_THRESHOLD
            ? ItemQuality::DAILY_DECREASE_DOUBLE * self::DAILY_QUALITY_DECREASE_RATE
            : ItemQuality::DAILY_DECREASE * self::DAILY_QUALITY_DECREASE_RATE;

        $item->quality = max(ItemQuality::MIN_VALUE, $item->quality - $qualityDecrement);
    }
}
