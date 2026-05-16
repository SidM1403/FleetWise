<?php

namespace App\Models;


use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FuelRecord extends Model
{
    use HasFactory, LogsActivity;
    
    protected $fillable = ['vehicle_id', 'quantity', 'cost', 'date'];

    protected $casts = ['date' => 'date'];

    public function vehicle() { return $this->belongsTo(Vehicle::class); }
}
