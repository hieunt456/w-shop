<?php

declare(strict_types=1);

namespace WolfShop\UseCases\Item;

use WolfShop\Domains\Item\Item;
use WolfShop\Domains\Item\ItemRepositoryInterface;

final class FindItemByName
{
    public function __construct(private readonly ItemRepositoryInterface $repository)
    {
        //
    }

    public function handle(string $itemName): Item|null
    {
        return $this->repository->getByName($itemName);
    }
}
