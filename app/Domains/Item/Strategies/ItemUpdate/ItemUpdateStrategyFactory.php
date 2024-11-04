<?php

declare(strict_types=1);

namespace WolfShop\Domains\Item\Strategies\ItemUpdate;

use WolfShop\Domains\Item\Item;

class ItemUpdateStrategyFactory
{
    private const DEFAULT_STRATEGY = NormalItemUpdate::class;

    private static array $strategies = [
        'samsung galaxy s23' => LegendaryItemUpdate::class,
        'apple airpods' => AppleAirPodsItemUpdate::class,
        'apple ipad air' => AppleIpadAirItemUpdate::class,
        'xiaomi redmi note 13' => ConjuredItemUpdate::class,
    ];

    public function getStrategy(Item $item): ItemUpdateStrategy
    {
        $strategyClass = self::$strategies[strtolower($item->name)] ?? self::DEFAULT_STRATEGY;

        return new $strategyClass();
    }
}
