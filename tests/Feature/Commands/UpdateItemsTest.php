<?php

declare(strict_types=1);

namespace Tests\Feature\Commands;

use Tests\TestCase;
use WolfShop\Domains\Item\Item;
use WolfShop\Domains\Item\ItemRepositoryInterface;

class UpdateItemsTest extends TestCase
{
    public function testTheCommandUpdatesAllItems(): void
    {
        $repository = $this->app->make(ItemRepositoryInterface::class);

        $normalItem = new Item('Normal Item', 10, 10);
        $repository->save($normalItem);

        $legendaryItem = new Item('Samsung Galaxy S23', 10, 80);
        $repository->save($legendaryItem);

        $airPodsItem = new Item('Apple Airpods', 5, 10);
        $repository->save($airPodsItem);

        $ipadAirItem = new Item('Apple iPad Air', 15, 10);
        $repository->save($ipadAirItem);

        $conjuredItem = new Item('Xiaomi Redmi Note 13', 10, 10);
        $repository->save($conjuredItem);

        $this->artisan('items:update')
            ->expectsOutput('Updating items...')
            ->expectsOutput('Update completed.')
            ->assertExitCode(0);

        $this->assertDatabaseHas('items', [
            'name' => 'Normal Item',
            'sell_in' => 9,
            'quality' => 9,
        ]);

        $this->assertDatabaseHas('items', [
            'name' => 'Samsung Galaxy S23',
            'sell_in' => 10,
            'quality' => 80,
        ]);

        $this->assertDatabaseHas('items', [
            'name' => 'Apple Airpods',
            'sell_in' => 4,
            'quality' => 11,
        ]);

        $this->assertDatabaseHas('items', [
            'name' => 'Apple iPad Air',
            'sell_in' => 14,
            'quality' => 11,
        ]);

        $this->assertDatabaseHas('items', [
            'name' => 'Xiaomi Redmi Note 13',
            'sell_in' => 9,
            'quality' => 8,
        ]);
    }
}
