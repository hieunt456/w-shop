<?php

declare(strict_types=1);

namespace Tests\Unit\UseCases\CreateItem;

use Tests\TestCase;
use WolfShop\Domains\Item\Strategies\ItemCreate\ItemCreateStrategyFactory;
use WolfShop\Domains\Item\Strategies\ItemCreate\LegendaryItemCreate;
use WolfShop\Domains\Item\Strategies\ItemCreate\NormalItemCreate;

class ItemCreateStrategyFactoryTest extends TestCase
{
    private ItemCreateStrategyFactory $factory;

    protected function setUp(): void
    {
        $this->factory = new ItemCreateStrategyFactory();
    }

    public function testReturnsLegendaryStrategyForSamsungGalaxy(): void
    {
        $attributes = ['name' => 'Samsung Galaxy S23'];
        $strategy = $this->factory->getStrategy($attributes);

        $this->assertInstanceOf(LegendaryItemCreate::class, $strategy);
    }

    public function testReturnsDefaultStrategyForOtherItems(): void
    {
        $attributes = ['name' => 'generic item'];
        $strategy = $this->factory->getStrategy($attributes);

        $this->assertInstanceOf(NormalItemCreate::class, $strategy);
    }

    public function testThrowsExceptionForMissingName(): void
    {
        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('Item name is required');

        $this->factory->getStrategy([]);
    }
}
