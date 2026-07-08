<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $fillable = [
        'location',
        'city_id',
        'status',
    ];

    protected $appends = ['created_at_formatted'];

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function getCreatedAtFormattedAttribute()
    {
        return $this->created_at?->format('m/y/d');
    }
}
