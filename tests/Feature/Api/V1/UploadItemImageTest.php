<?php

declare(strict_types=1);

namespace Tests\Feature\Api\V1;

use Illuminate\Http\UploadedFile;
use Tests\TestCase;
use WolfShop\Domains\Item\Item;
use WolfShop\Domains\Item\ItemRepositoryInterface;
use WolfShop\Models\User;

class UploadItemImageTest extends TestCase
{
    public function testUploadImageSuccessfully(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $repository = $this->app->make(ItemRepositoryInterface::class);
        $item = new Item('Item', 10, 20);
        $repository->save($item);

        $imageFile = UploadedFile::fake()->image('test-image.png');

        $response = $this->putJson(route('items.image.upload', ['item' => $item->name]), [
            'image' => $imageFile,
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Image uploaded successfully.',
                'status' => 200,
            ]);
    }

    public function testUploadImageForNonExistentItem(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $nonexistentItemName = 'Nonexistent Item';
        $response = $this->putJson(route('items.image.upload', ['item' => $nonexistentItemName]), [
            'image' => UploadedFile::fake()->image('test-image.png'),
        ]);

        $response->assertStatus(500)
            ->assertJson([
                'errors' => [
                    [
                        'type' => 'Illuminate\\Database\\Eloquent\\ModelNotFoundException',
                        'status' => 404,
                        'message' => "Item with name $nonexistentItemName not found.",
                    ],
                ],
            ]);
    }
}
