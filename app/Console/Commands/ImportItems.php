<?php

declare(strict_types=1);

namespace WolfShop\Console\Commands;

use Illuminate\Console\Command;
use WolfShop\DTOs\ApiItemDTO;
use WolfShop\Services\ItemsImporter\ItemsImportable;
use WolfShop\UseCases\Item\CreateItem;
use WolfShop\UseCases\Item\FindItemByName;
use WolfShop\UseCases\Item\UpdateItem;

final class ImportItems extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'items:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import items from external source';

    /**
     * Execute the console command.
     */
    public function handle(
        ItemsImportable $importService,
        FindItemByName $findItemByName,
        UpdateItem $updateItem,
        CreateItem $createItem
    ): int
    {
        $this->info('Importing items...');
        $itemCreationCount = 0;

        try {
            $rawItems = $importService->import();

            foreach ($rawItems as $rawItem) {
                $apiItemDto = new ApiItemDTO($rawItem);
                $itemName = $apiItemDto->getName();

                if (empty($itemName)) {
                    $this->warn('Item name is missing. Skipping...');
                    continue;
                }

                if ($item = $findItemByName->handle($itemName)) {
                    $updateItem->handle($item);
                } else {
                    $createItem->handle($apiItemDto->toArray());
                    $itemCreationCount++;
                }
            }

            $this->table(
                ['Total items', 'Created', 'Updated'],
                [[count($rawItems), $itemCreationCount, count($rawItems) - $itemCreationCount]]
            );

            $this->info('Import completed.');

            return self::SUCCESS;
        } catch (\Exception $e) {
            report($e);
            $this->error($e->getMessage());
            return self::FAILURE;
        }
    }
}
