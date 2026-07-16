<?php

namespace App\Models;

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
        'session_not_conv_reason'
    ];

    protected $casts = [
        'kachehri_date' => 'date:Y-m-d',
        'kachehri_number' => 'integer',
        'dfp_ids' => 'array'
    ];

    public function attendees(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'ekachehri_attendees', 'ekachehri_id', 'attendee_id');
    }
}
