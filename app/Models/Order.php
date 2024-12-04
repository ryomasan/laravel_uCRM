<?php

namespace App\Models;

use App\Models\Scopes\SubTotal;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    /**
     * モデルの「起動」メソッド
     *
     * @return void
     */
    protected static function booted()
    {
        static::addGlobalScope(new SubTotal);
    }
}
