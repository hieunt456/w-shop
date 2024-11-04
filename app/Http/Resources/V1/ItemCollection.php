<?php

declare(strict_types=1);

namespace WolfShop\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use ReflectionProperty;
use WolfShop\Domains\Item\Item;

class ItemCollection extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'data' => array_map($this->parseItem(...), $this->resource['data']),
            'per_page' => $this->resource['per_page'],
            'current_page' => $this->resource['current_page'],
            'last_page' => $this->resource['last_page'],
            'from' => $this->resource['from'],
            'to' => $this->resource['to'],
            'total' => $this->resource['total'],
            'prev_page_url' => $this->resource['prev_page_url'],
            'next_page_url' => $this->resource['next_page_url'],
        ];
    }

    private function parseItem(Item $item): array
    {
        return [
            'name' => $item->name,
            'sellIn' => $item->sellIn,
            'quality' => $item->quality,
            'imgUrl' => $this->getImgUrl($item),
        ];
    }

    private function getImgUrl(Item $item): ?string
    {
        $reflection = new ReflectionProperty($item, 'imgUrl');

        return $reflection->isInitialized($item) ? $item->getImgUrl() : null;
    }
}
