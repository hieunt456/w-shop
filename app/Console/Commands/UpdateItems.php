<?php

declare(strict_types=1);

namespace WolfShop\Console\Commands;

use Illuminate\Console\Command;
use WolfShop\UseCases\Item\UpdateAllItems;

final class UpdateItems extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'items:update
                            {--chunk= : The number of items to update at a time}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update all items.';

    /**
     * Execute the console command.
     */
    public function handle(UpdateAllItems $updateAllItems): int
    {
        $this->info('Updating items...');

        $chunkSize = $this->option('chunk');

        if (is_array($chunkSize) || is_string($chunkSize)) {
            $this->error('The chunk option must be a number.');
            return self::FAILURE;
        }

        try {
            $updateAllItems->handle($chunkSize);
            $this->info('Update completed.');
            return self::SUCCESS;
        } catch (\Exception $e) {
            report($e);
            $this->error($e->getMessage());
            return self::FAILURE;
        }
    }
}
