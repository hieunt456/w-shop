<?php

declare(strict_types=1);

namespace WolfShop\Domains\Item\Strategies\ItemUpdate;

use WolfShop\Domains\Item\Item;
use WolfShop\Domains\Item\ItemQuality;
use WolfShop\Domains\Item\ItemSellIn;

final class NormalItemUpdate implements ItemUpdateStrategy
{
    public function update(Item $item): void
    {
        $item->sellIn--;

        $qualityDecrement = $item->sellIn < ItemSellIn::EXPIRATION_THRESHOLD
            ? ItemQuality::DAILY_DECREASE_DOUBLE
            : ItemQuality::DAILY_DECREASE;

        $item->quality = max(ItemQuality::MIN_VALUE, $item->quality - $qualityDecrement);
    }
}
