<?php

declare(strict_types=1);

namespace WolfShop\UseCases\Item;

use WolfShop\Domains\Item\ItemRepositoryInterface;

final class GetAllItems
{
    public function __construct(private readonly ItemRepositoryInterface $repository)
    {
        //
    }

    public function handle(): array
    {
        return $this->repository->getAll();
    }
}
