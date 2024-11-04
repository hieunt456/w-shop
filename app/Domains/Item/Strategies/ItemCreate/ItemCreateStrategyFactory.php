<?php

declare(strict_types=1);

namespace WolfShop\Domains\Item\Strategies\ItemCreate;

class ItemCreateStrategyFactory
{
    private const DEFAULT_STRATEGY = NormalItemCreate::class;

    private static array $strategies = [
        'samsung galaxy s23' => LegendaryItemCreate::class,
    ];

    public function getStrategy(array $attributes): ItemCreateStrategy
    {
        if (empty($attributes['name'])) {
            throw new \DomainException('Item name is required');
        }

        $strategyClass = self::$strategies[strtolower($attributes['name'])] ?? self::DEFAULT_STRATEGY;

        return new $strategyClass();
    }
}
