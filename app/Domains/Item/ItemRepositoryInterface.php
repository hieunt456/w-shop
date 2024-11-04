<?php

declare(strict_types=1);

namespace WolfShop\Domains\Item;

interface ItemRepositoryInterface
{
    public function getAll(): array;

    public function getByName(string $name): Item|null;

    public function save(Item $item): void;

    public function update(Item $item): void;

    public function chunk(int $size, callable $callback): void;
}
