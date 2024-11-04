<?php

declare(strict_types=1);

namespace WolfShop\Services\ItemsImporter;

use Illuminate\Support\Facades\Http;

class ApiImportService implements ItemsImportable
{
    public const DEFAULT_URL = 'https://api.restful-api.dev/objects';

    private string $apiUrl;

    public function __construct(string $url = '')
    {
        $this->apiUrl = empty($url) ? self::DEFAULT_URL : $url;
    }

    public function import(): array
    {
        return Http::get($this->apiUrl)->throw()->json();
    }
}
