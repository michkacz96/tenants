<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UtilityMeterReading extends Model
{
    use HasFactory;

    public function utilityMeter(){
        return $this->belongsTo(UtilityMeter::class);
    }

    public function unit(){
        return $this->belongsTo(Unit::class);
    }
}
