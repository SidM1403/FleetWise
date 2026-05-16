<?php

namespace App\Models;


use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    use HasFactory, LogsActivity;
    
    protected $fillable = [
        'vehicle_id', 'driver_id', 'origin', 'destination', 
        'start_odometer', 'end_odometer', 'departure_time', 
        'arrival_time', 'distance', 'status'
    ];

    protected $casts = [
        'departure_time' => 'datetime',
        'arrival_time'   => 'datetime',
    ];

    public function vehicle()  { return $this->belongsTo(Vehicle::class); }
    public function driver()   { return $this->belongsTo(Driver::class); }
    public function expenses() { return $this->hasMany(Expense::class); }
}
