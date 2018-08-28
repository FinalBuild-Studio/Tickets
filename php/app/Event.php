<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{

    protected $fillable = [
        'name',
        'address',
        'place',
        'start_at',
        'end_at',
        'max',
        'price',
        'poster',
        'description',
        'template',
        'discount_rate',
        'sponsor_tickets',
    ];

    protected $dates = [
        'start_at',
        'end_at',
    ];

    public function order()
    {
        return $this->hasMany(Order::class);
    }

    public function getLeftSponsorTicketsAttribute()
    {
        return $this->sponsor_tickets - $this
            ->order()
            ->where('status', Order::PAID)
            ->where('is_sponsor', true)
            ->sum('total');
    }

    public function getExpiredAttribute()
    {
        return $this->start_at < new Carbon('-1 days');
    }

    public function getLeftAttribute()
    {
        return $this->max - $this
            ->order()
            ->where('status', Order::PAID)
            ->where('is_sponsor', false)
            ->sum('total');
    }
}
