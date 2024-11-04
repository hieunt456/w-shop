<?php

declare(strict_types=1);

namespace Tests\Feature\Api\V1;

use Tests\TestCase;
use WolfShop\Domains\Item\Item;
use WolfShop\Domains\Item\ItemRepositoryInterface;
use WolfShop\Models\User;

class GetAllItemsTest extends TestCase
{
    public function testIndexReturnsAllItems(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $repository = $this->app->make(ItemRepositoryInterface::class);
        $item1 = new Item('Item 1', 10, 20);
        $repository->save($item1);
        $item2 = new Item('Item 2', 5, 15);
        $repository->save($item2);

        $response = $this->getJson(route('items.index'));

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'data' => [
                '*' => ['name', 'sellIn', 'quality', 'imgUrl'],
            ],
            'per_page',
            'current_page',
            'last_page',
            'from',
            'to',
            'total',
            'prev_page_url',
            'next_page_url',
        ]);
    }
}
