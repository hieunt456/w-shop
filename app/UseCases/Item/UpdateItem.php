<?php

declare(strict_types=1);

namespace WolfShop\UseCases\Item;

use WolfShop\Domains\Item\Item;
use WolfShop\Domains\Item\ItemRepositoryInterface;
use WolfShop\Domains\Item\Strategies\ItemUpdate\ItemUpdateStrategyFactory;

final class UpdateItem
{
    public function __construct(
        private readonly ItemRepositoryInterface $repository,
        private readonly ItemUpdateStrategyFactory $factory
    )
    {
        //
    }
    public function handle(Item $item): void
    {
        $strategy = $this->factory->getStrategy($item);

        $strategy->update($item);

        $this->repository->update($item);
    }
}
