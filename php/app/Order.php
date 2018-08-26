<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

    public const INITIAL = 0;
    public const PAID    = 1;
    public const CONFIRM = 2;

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
