<?php

declare(strict_types=1);

namespace WolfShop\Domains\Item;

final class ItemSellIn
{
    public const EXPIRATION_THRESHOLD = 0;

    public static function defaultValue(): int
    {
        return config('wolfshop.normal_item_default_sell_in');
    }
}
