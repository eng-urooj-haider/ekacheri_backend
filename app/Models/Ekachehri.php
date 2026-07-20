<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Ekachehri extends Model
{
    use HasFactory;

    protected $fillable = [
        'kachehri_number',
        'venue',
        'session',
        'kachehri_date',
        'kachehri_time',
        'location',
        'status',
        'dfp_ids',
        'complaint_received',
        'session_convened',
        'session_not_conv_reason',
        'createdby',
        'uuid'
    ];

   protected $casts = [
    'kachehri_date' => 'date:Y-m-d',
    'kachehri_time' => 'datetime:H:i:s',
    'kachehri_number' => 'integer',
    'dfp_ids' => 'array',
];


    protected $appends = ['kachehri_date_formatted','kachehri_time_formatted'];
    public function attendees(): BelongsToMany
    {
        return $this->belongsToMany(
            User::class,
            'ekachehri_attendees',
            'ekachehri_id',
            'attendee_id'
        );
    }

    public function getKachehriDateFormattedAttribute()
    {
        return $this->kachehri_date?->format('d/m/Y');
    }

   public function getKachehriTimeFormattedAttribute()
{
    return $this->kachehri_time
        ? Carbon::parse($this->kachehri_time)->format('h:i A')
        : null;
}

}

