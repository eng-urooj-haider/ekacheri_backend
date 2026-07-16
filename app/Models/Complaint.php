<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Complaint extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_number',
        'contact_number',
        'telco',
        'complaint_category',
        'complaint_type',
        'complaint_details',
        'priority',
        'status',
    ];

    public function departments(): BelongsToMany
    {
        return $this->belongsToMany(Department::class, 'complaint_department', 'complaint_id', 'department_id');
    }
}
