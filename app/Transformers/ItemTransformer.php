<?php

declare(strict_types=1);

namespace WolfShop\Transformers;

use ReflectionProperty;
use WolfShop\Domains\Item\Item as DomainItem;
use WolfShop\Models\Item as InfraItem;

final class ItemTransformer
{
    public static function infraToDomain(InfraItem $item): DomainItem
    {
        $domainItem = new DomainItem(
            $item->name,
            $item->sell_in,
            $item->quality,
        );

        if ($item->img_url) {
            $domainItem->setImgUrl($item->img_url);
        }

        return $domainItem;
    }

    public static function domainToInfra(DomainItem $item): InfraItem
    {
        $infraItem = new InfraItem();
        $infraItem->name = $item->name;
        $infraItem->sell_in = $item->sellIn;
        $infraItem->quality = $item->quality;

        $reflection = new ReflectionProperty($item, 'imgUrl');
        if ($reflection->isInitialized($item)) {
            $infraItem->img_url = $item->getImgUrl();
        }

        return $infraItem;
    }
}
