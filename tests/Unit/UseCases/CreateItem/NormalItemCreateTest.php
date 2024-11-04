<?php

declare(strict_types=1);

namespace Tests\Unit\UseCases\CreateItem;

use Tests\TestCase;
use WolfShop\Domains\Item\Item;
use WolfShop\Domains\Item\ItemQuality;
use WolfShop\Domains\Item\ItemSellIn;
use WolfShop\Domains\Item\Strategies\ItemCreate\NormalItemCreate;

class NormalItemCreateTest extends TestCase
{
    public function testCreatesItemWithGivenAttributes(): void
    {
        $attributes = [
            'name' => 'generic item',
            'sellIn' => 10,
            'quality' => 20,
        ];

        $normalCreate = new NormalItemCreate();
        $item = $normalCreate->create($attributes);

        $this->assertInstanceOf(Item::class, $item);
        $this->assertEquals('generic item', $item->name);
        $this->assertEquals(10, $item->sellIn);
        $this->assertEquals(20, $item->quality);
    }

    public function testCreatesItemWithDefaultSellInAndQuality(): void
    {
        $attributes = ['name' => 'generic item'];

        $normalCreate = new NormalItemCreate();
        $item = $normalCreate->create($attributes);

        $this->assertInstanceOf(Item::class, $item);
        $this->assertEquals('generic item', $item->name);
        $this->assertEquals(ItemSellIn::defaultValue(), $item->sellIn);
        $this->assertEquals(ItemQuality::defaultValue(), $item->quality);
    }
}
