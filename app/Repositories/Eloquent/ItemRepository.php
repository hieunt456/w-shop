<?php

declare(strict_types=1);

namespace WolfShop\Repositories\Eloquent;

use Illuminate\Database\Eloquent\Collection;
use ReflectionProperty;
use WolfShop\Domains\Item\Item as DomainItem;
use WolfShop\Domains\Item\ItemRepositoryInterface;
use WolfShop\Models\Item as InfraItem;
use WolfShop\Transformers\ItemTransformer;

class ItemRepository implements ItemRepositoryInterface
{
    public function update(DomainItem $item): void
    {
        $infraItem = InfraItem::where('name', $item->name)->first();

        if (!$infraItem) {
            return;
        }

        $infraItem->sell_in = $item->sellIn;
        $infraItem->quality = $item->quality;
        $reflection = new ReflectionProperty($item, 'imgUrl');
        if ($reflection->isInitialized($item)) {
            $infraItem->img_url = $item->getImgUrl();
        }

        $infraItem->save();
    }
}
