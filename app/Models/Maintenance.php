<?php

namespace App\Models;


use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Maintenance extends Model
{
    use HasFactory, LogsActivity;
    
    protected $fillable = ['vehicle_id', 'service_type', 'cost', 'description', 'service_date', 'next_service_date', 'status'];

    protected $casts = [
        'service_date'      => 'date',
        'next_service_date' => 'date',
    ];

    public function vehicle() { return $this->belongsTo(Vehicle::class); }

    public function scopeUpcoming($query)
    {
        return $query->whereNotNull('next_service_date')
                     ->whereBetween('next_service_date', [now(), now()->addDays(7)]);
    }
}
