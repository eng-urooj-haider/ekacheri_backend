<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $fillable = [
        'title',
        'status',
    ];
    protected $appends = ['created_at_formatted'];
    public function getCreatedAtFormattedAttribute()
    {
        return $this->created_at?->format('m/y/d');
    }
}
