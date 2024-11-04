<?php

declare(strict_types=1);

namespace Tests\Unit\UseCases\CreateItem;

use Tests\TestCase;
use WolfShop\Domains\Item\Item;
use WolfShop\Domains\Item\ItemQuality;
use WolfShop\Domains\Item\ItemSellIn;
use WolfShop\Domains\Item\Strategies\ItemCreate\LegendaryItemCreate;

class LegendaryItemCreateTest extends TestCase
{
    public function testCreatesLegendaryItemWithFixedSellInAndQuality(): void
    {
        $attributes = ['name' => 'Legendary Item'];

        $legendaryCreate = new LegendaryItemCreate();
        $item = $legendaryCreate->create($attributes);

        $this->assertInstanceOf(Item::class, $item);
        $this->assertEquals('Legendary Item', $item->name);
        $this->assertEquals(ItemSellIn::EXPIRATION_THRESHOLD, $item->sellIn);
        $this->assertEquals(ItemQuality::LEGENDARY_VALUE, $item->quality);
    }
}
