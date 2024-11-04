<?php

declare(strict_types=1);

namespace WolfShop\Domains\Item\Strategies\ItemCreate;

use WolfShop\Domains\Item\Item;
use WolfShop\Domains\Item\ItemQuality;
use WolfShop\Domains\Item\ItemSellIn;

final class LegendaryItemCreate implements ItemCreateStrategy
{
    public function create(array $attributes): Item
    {
        return new Item(
            $attributes['name'],
            ItemSellIn::EXPIRATION_THRESHOLD,
            ItemQuality::LEGENDARY_VALUE,
        );
    }
}
