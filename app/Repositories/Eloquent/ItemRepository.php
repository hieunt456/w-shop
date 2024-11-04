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
    public function getAll(): array
    {
        return InfraItem::paginate()
            ->through(fn ($item) => ItemTransformer::infraToDomain($item))
            ->toArray();
    }

    public function getByName(string $name): DomainItem|null
    {
        $item = InfraItem::where('name', $name)->first();

        if (!$item) {
            return null;
        }

        return ItemTransformer::infraToDomain($item);
    }

    public function save(DomainItem $item): void
    {
        $infraItem = ItemTransformer::domainToInfra($item);

        $infraItem->save();
    }

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

    public function chunk(int $size, callable $callback): void
    {
        InfraItem::chunk($size, static function (Collection $items) use ($callback) {
            $domainItems = $items->map(fn($item) => ItemTransformer::infraToDomain($item))->all();

            $callback($domainItems);
        });
    }
}
