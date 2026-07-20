<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Complaint extends Model
{
    use HasFactory;
    protected $appends = ['closure_date_formatted'];

    protected $fillable = [
        'customer_number',
        'contact_number',
        'name',
        'telco',
        'complaint_category',
        'complaint_type',
        'complaint_details',
        'priority',
        'status',
        'disposal_status',
        'closure_date',
        'closure_time',
        'department_status',
        'customer_feedback',
        'department'
    ];
      protected $casts = [
    'closure_date' => 'date:Y-m-d',
];
    public function departments(): BelongsToMany
    {
        return $this->belongsToMany(Department::class, 'complaint_department', 'complaint_id', 'department_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'createdby');
    }
    public function getClosureDateFormattedAttribute()
    {
        return $this->closure_date?->format('m/y/d');
    }
}