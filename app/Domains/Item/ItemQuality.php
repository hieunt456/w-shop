<?php

declare(strict_types=1);

namespace WolfShop\Domains\Item;

final class ItemQuality
{
    public const MIN_VALUE = 0;

    public const MAX_VALUE = 50;

    public const LEGENDARY_VALUE = 80;

    public const DAILY_DECREASE = 1;

    public const DAILY_DECREASE_DOUBLE = 2;

    public static function defaultValue(): int
    {
        return config('wolfshop.normal_item_default_quality');
    }
}
