<?php

declare(strict_types=1);

namespace WolfShop\Services\ItemsImporter;

interface ItemsImportable
{
    public function import(): array;
}
