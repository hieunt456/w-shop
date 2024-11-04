<?php

declare(strict_types=1);

namespace WolfShop\Http\Controllers\Api\V1;

use Illuminate\Http\Resources\Json\JsonResource;
use WolfShop\Http\Resources\V1\ItemCollection;
use WolfShop\UseCases\Item\GetAllItems;

class ItemController
{
    public function index(GetAllItems $getAllItems): JsonResource
    {
        // TODO: Handle filtering, sorting and pagination
        $items = $getAllItems->handle();

        return new ItemCollection($items);
    }
}
