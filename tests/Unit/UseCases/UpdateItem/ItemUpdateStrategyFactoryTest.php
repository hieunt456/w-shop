<?php

declare(strict_types=1);

namespace Tests\Unit\UseCases\UpdateItem;

use Tests\TestCase;
use WolfShop\Domains\Item\Item;
use WolfShop\Domains\Item\Strategies\ItemUpdate\AppleAirPodsItemUpdate;
use WolfShop\Domains\Item\Strategies\ItemUpdate\AppleIpadAirItemUpdate;
use WolfShop\Domains\Item\Strategies\ItemUpdate\ConjuredItemUpdate;
use WolfShop\Domains\Item\Strategies\ItemUpdate\ItemUpdateStrategyFactory;
use WolfShop\Domains\Item\Strategies\ItemUpdate\LegendaryItemUpdate;
use WolfShop\Domains\Item\Strategies\ItemUpdate\NormalItemUpdate;

class ItemUpdateStrategyFactoryTest extends TestCase
{
    private ItemUpdateStrategyFactory $factory;

    protected function setUp(): void
    {
        $this->factory = new ItemUpdateStrategyFactory();
    }

    public function testReturnsLegendaryStrategyForSamsungGalaxy(): void
    {
        $item = new Item('Samsung Galaxy S23', 10, 20);
        $strategy = $this->factory->getStrategy($item);

        $this->assertInstanceOf(LegendaryItemUpdate::class, $strategy);
    }

    public function testReturnsAirPodsStrategyForAppleAirPods(): void
    {
        $item = new Item('Apple AirPods', 10, 20);
        $strategy = $this->factory->getStrategy($item);

        $this->assertInstanceOf(AppleAirPodsItemUpdate::class, $strategy);
    }

    public function testReturnsIpadAirStrategyForAppleIpadAir(): void
    {
        $item = new Item('Apple iPad Air', 10, 20);
        $strategy = $this->factory->getStrategy($item);

        $this->assertInstanceOf(AppleIpadAirItemUpdate::class, $strategy);
    }

    public function testReturnsConjuredStrategyForXiaomiRedmiNote(): void
    {
        $item = new Item('Xiaomi Redmi Note 13', 10, 20);
        $strategy = $this->factory->getStrategy($item);

        $this->assertInstanceOf(ConjuredItemUpdate::class, $strategy);
    }

    public function testReturnsDefaultStrategyForOtherItems(): void
    {
        $item = new Item('Generic Item', 10, 20);
        $strategy = $this->factory->getStrategy($item);

        $this->assertInstanceOf(NormalItemUpdate::class, $strategy);
    }
}
