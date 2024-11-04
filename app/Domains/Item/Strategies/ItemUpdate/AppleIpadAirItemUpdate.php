<?php

declare(strict_types=1);

namespace WolfShop\Domains\Item\Strategies\ItemUpdate;

use WolfShop\Domains\Item\Item;
use WolfShop\Domains\Item\ItemQuality;
use WolfShop\Domains\Item\ItemSellIn;

final class AppleIpadAirItemUpdate implements ItemUpdateStrategy
{
    private const DAILY_QUALITY_INCREASE = 1;

    private const DAILY_QUALITY_INCREASE_DOUBLE = 2;

    private const DAILY_QUALITY_INCREASE_TRIPLE = 3;

    private const DOUBLE_QUALITY_INCREASE_THRESHOLD = 10;

    private const TRIPLE_QUALITY_INCREASE_THRESHOLD = 5;

    public function update(Item $item): void
    {
        $item->sellIn--;

        if ($item->sellIn <= ItemSellIn::EXPIRATION_THRESHOLD) {
            $item->quality = ItemQuality::MIN_VALUE;
            return;
        }

        $qualityIncrement = match (true) {
            $item->sellIn <= self::TRIPLE_QUALITY_INCREASE_THRESHOLD => self::DAILY_QUALITY_INCREASE_TRIPLE,
            $item->sellIn <= self::DOUBLE_QUALITY_INCREASE_THRESHOLD => self::DAILY_QUALITY_INCREASE_DOUBLE,
            default => self::DAILY_QUALITY_INCREASE,
        };

        $item->quality = min(ItemQuality::MAX_VALUE, $item->quality + $qualityIncrement);
    }
}
