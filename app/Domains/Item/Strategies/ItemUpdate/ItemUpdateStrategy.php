<?php

declare(strict_types=1);

namespace WolfShop\Domains\Item\Strategies\ItemUpdate;

use WolfShop\Domains\Item\Item;

interface ItemUpdateStrategy
{
    public function update(Item $item): void;
}
