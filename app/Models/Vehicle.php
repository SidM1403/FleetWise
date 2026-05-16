<?php

namespace App\Models;


use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory, LogsActivity;
    
    protected $fillable = [
        'vehicle_number', 'vehicle_type', 'model', 'capacity', 
        'registration_date', 'insurance_expiry', 'status'
    ];

    protected $casts = [
        'registration_date' => 'date',
        'insurance_expiry' => 'date',
    ];

    public function driver()       { return $this->hasOne(Driver::class); }
    public function trips()        { return $this->hasMany(Trip::class); }
    public function maintenances() { return $this->hasMany(Maintenance::class); }
    public function fuelRecords()  { return $this->hasMany(FuelRecord::class); }
    public function expenses()     { return $this->hasMany(Expense::class); }

    public function currentMileage()
    {
        return $this->trips()->max('end_odometer') ?? $this->trips()->max('start_odometer') ?? 0;
    }
}
