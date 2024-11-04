<?php

declare(strict_types=1);

namespace WolfShop\UseCases\Item;

use WolfShop\Domains\Item\ItemRepositoryInterface;
use WolfShop\Domains\Item\Strategies\ItemCreate\ItemCreateStrategyFactory;

final class CreateItem
{
    public function __construct(
        private readonly ItemRepositoryInterface $repository,
        private readonly ItemCreateStrategyFactory $factory,
    )
    {
        //
    }

    public function handle(array $attributes): void
    {
        $itemCreateStrategy = $this->factory->getStrategy($attributes);

        $item = $itemCreateStrategy->create($attributes);

        $this->repository->save($item);
    }
}
