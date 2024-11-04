<?php

declare(strict_types=1);

namespace WolfShop\Domains\Item\Strategies\ItemUpdate;

use WolfShop\Domains\Item\Item;

final class LegendaryItemUpdate implements ItemUpdateStrategy
{
    public function update(Item $item): void
    {
        // Legendary item quality does not change
    }
}
