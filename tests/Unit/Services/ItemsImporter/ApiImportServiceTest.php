<?php

declare(strict_types=1);

namespace Tests\Unit\Services\ItemsImporter;

use Illuminate\Support\Facades\Http;
use Tests\TestCase;
use WolfShop\Services\ItemsImporter\ApiImportService;

class ApiImportServiceTest extends TestCase
{
    public function testImportCallsHttpClientAndReturnsJson(): void
    {
        $expectedResponse = ['key' => 'value'];

        Http::shouldReceive('get')
            ->once()
            ->with(ApiImportService::DEFAULT_URL)
            ->andReturnSelf();

        Http::shouldReceive('throw')
            ->once()
            ->andReturnSelf();

        Http::shouldReceive('json')
            ->once()
            ->andReturn($expectedResponse);

        $service = new ApiImportService();

        $response = $service->import();

        $this->assertEquals($expectedResponse, $response);
    }
}
