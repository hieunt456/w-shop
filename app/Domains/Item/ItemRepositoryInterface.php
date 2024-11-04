<?php

declare(strict_types=1);

namespace WolfShop\Domains\Item;

interface ItemRepositoryInterface
{
    public function update(Item $item): void;
}
