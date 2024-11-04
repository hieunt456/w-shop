<?php

namespace WolfShop\Providers;

use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Support\ServiceProvider;
use WolfShop\Domains\Item\ItemRepositoryInterface;
use WolfShop\Exceptions\Handler;
use WolfShop\Repositories\Eloquent\ItemRepository;
use WolfShop\Services\ImageStorage\CloudinaryStorage;
use WolfShop\Services\ImageStorage\ImageStorable;
use WolfShop\Services\ItemsImporter\ApiImportService;
use WolfShop\Services\ItemsImporter\ItemsImportable;

class AppServiceProvider extends ServiceProvider
{
    /**
     * All of the container bindings that should be registered.
     *
     * @var array
     */
    public $bindings = [
        ItemRepositoryInterface::class => ItemRepository::class,
        ItemsImportable::class => ApiImportService::class,
        ExceptionHandler::class => Handler::class,
        ImageStorable::class => CloudinaryStorage::class,
    ];

    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
