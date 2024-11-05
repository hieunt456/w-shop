<?php

declare(strict_types=1);

namespace Tests\Feature\Commands;

use Illuminate\Support\Facades\Config;
use Mockery;
use Tests\TestCase;
use WolfShop\Domains\Item\Item;
use WolfShop\Domains\Item\ItemRepositoryInterface;
use WolfShop\Services\ItemsImporter\ItemsImportable;

class ImportItemsTest extends TestCase
{
    public function testImportItemsCreatesAndUpdatesItems(): void
    {
        $defaultSellIn = random_int(1, 30);
        $defaultQuality = random_int(1, 30);
        Config::set('wolfshop.normal_item_default_sell_in', $defaultSellIn);
        Config::set('wolfshop.normal_item_default_quality', $defaultQuality);

        $itemRepository = $this->app->make(ItemRepositoryInterface::class);
        $item = new Item('Existing Item', 20, 30);
        $itemRepository->save($item);

        $this->app->instance(ItemsImportable::class, Mockery::mock(ItemsImportable::class, static function ($mock) {
            $mock->shouldReceive('import')->andReturn([
                ['name' => null],
                ['name' => 'Normal Item', 'sellIn' => 10, 'quality' => 10],
                ['name' => 'Legendary Item', 'sellIn' => 5, 'quality' => 80],
                ['name' => 'Existing Item', 'sellIn' => 30, 'quality' => 50],
                ['name' => 'Default Item'],
            ]);
        }));

        $this->artisan('items:import')
            ->expectsOutput('Importing items...')
            ->expectsOutput('Item name is missing. Skipping...')
            ->expectsOutput('Import completed.')
            ->assertExitCode(0);

        $this->assertDatabaseHas('items', [
            'name' => 'Normal Item',
            'sell_in' => 10,
            'quality' => 10,
        ]);

        $this->assertDatabaseHas('items', [
            'name' => 'Legendary Item',
            'sell_in' => 5,
            'quality' => 80,
        ]);

        $this->assertDatabaseHas('items', [
            'name' => 'Existing Item',
            'sell_in' => 19,
            'quality' => 29,
        ]);

        $this->assertDatabaseHas('items', [
            'name' => 'Default Item',
            'sell_in' => $defaultSellIn,
            'quality' => $defaultQuality,
        ]);
    }
}
