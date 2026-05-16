<?php

namespace App\Models;


use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    use HasFactory, LogsActivity;
    
    protected $fillable = ['vehicle_id', 'name', 'phone', 'license_number', 'address'];

    public function vehicle() { return $this->belongsTo(Vehicle::class); }
    public function trips()   { return $this->hasMany(Trip::class); }
}
