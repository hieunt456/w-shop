<?php

declare(strict_types=1);

namespace Tests\Feature\Commands;

use Mockery;
use Tests\TestCase;
use WolfShop\Domains\Item\Item;
use WolfShop\Domains\Item\ItemRepositoryInterface;
use WolfShop\Services\ItemsImporter\ItemsImportable;

class ImportItemsTest extends TestCase
{
    public function testImportItemsCreatesAndUpdatesItems(): void
    {
        $itemRepository = $this->app->make(ItemRepositoryInterface::class);
        $item = new Item('Existing Item', 20, 30);
        $itemRepository->save($item);

        $this->app->instance(ItemsImportable::class, Mockery::mock(ItemsImportable::class, static function ($mock) {
            $mock->shouldReceive('import')->andReturn([
                ['name' => 'Normal Item', 'sellIn' => 10, 'quality' => 10],
                ['name' => 'Legendary Item', 'sellIn' => 5, 'quality' => 80],
                ['name' => 'Existing Item', 'sellIn' => 30, 'quality' => 50], // To test update
            ]);
        }));

        $this->artisan('items:import')
            ->expectsOutput('Importing items...')
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
    }
}
