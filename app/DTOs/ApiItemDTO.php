<?php

declare(strict_types=1);

namespace WolfShop\DTOs;

final class ApiItemDTO
{
    private string $name;

    private int $sellIn;

    private int $quality;

    public function __construct(
        private readonly array $data,
    ) {
        $this->parseData();
    }

    private function parseData(): void
    {
        $this->name = $this->data['name'] ?? '';
        $this->sellIn = $this->data['sellIn'] ?? config('wolfshop.normal_item_default_sell_in');
        $this->quality = $this->data['quality'] ?? config('wolfshop.normal_item_default_quality');
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getSellIn(): int
    {
        return $this->sellIn;
    }

    public function getQuality(): int
    {
        return $this->quality;
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'sellIn' => $this->sellIn,
            'quality' => $this->quality,
        ];
    }
}
