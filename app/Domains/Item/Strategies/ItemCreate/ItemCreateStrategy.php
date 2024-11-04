<?php

declare(strict_types=1);

namespace WolfShop\Domains\Item\Strategies\ItemCreate;

use WolfShop\Domains\Item\Item;

interface ItemCreateStrategy
{
    public function create(array $attributes): Item;
}
