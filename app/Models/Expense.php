<?php

namespace App\Models;


use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory, LogsActivity;
    
    protected $fillable = ['vehicle_id', 'trip_id', 'amount', 'category', 'description', 'date', 'status', 'approved_by'];

    protected $casts = ['date' => 'date'];

    public function vehicle()  { return $this->belongsTo(Vehicle::class); }
    public function trip()     { return $this->belongsTo(Trip::class); }
    public function approver() { return $this->belongsTo(User::class, 'approved_by'); }
}
