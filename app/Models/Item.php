<?php

declare(strict_types=1);

namespace WolfShop\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = [
        'name',
        'sell_in',
        'quality',
        'img_url',
    ];

    protected $perPage = 10;
}
