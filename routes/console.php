<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Schedule::command('item:update')->dailyAt(config('wolfshop.daily_items_update_time'))->sendOutputTo('/dev/tty');
