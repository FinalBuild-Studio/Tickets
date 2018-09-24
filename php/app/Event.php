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
        'memo',
        'invitation_code',
        'related_event_ids',
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
            ->whereIn('status', [Order::PAID, Order::CONFIRM])
            ->where('is_sponsor', true)
            ->sum('total');
    }

    public function getRelatedEventIds($value)
    {
        return $value ? json_decode($value, true) : null;
    }

    public function getExpiredAttribute()
    {
        return $this->start_at < new Carbon('-1 days');
    }

    public function getTotalTicketsAttribute()
    {
        return $this->max + $this->sponsor_tickets;
    }

    public function getLeftAttribute()
    {
        return $this->max - $this
            ->order()
            ->whereIn('status', [Order::PAID, Order::CONFIRM])
            ->where('is_sponsor', false)
            ->sum('total');
    }
}
