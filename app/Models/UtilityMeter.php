<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UtilityMeter extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function user(){
        return $this->belongsTo(Property::class)->withTrashed();
    }

    public function property(){
        return $this->belongsTo(Property::class)->withTrashed();
    }

    public function utilityMeterType(){
        return $this->belongsTo(UtilityMeterType::class)->withTrashed();
    }

    public function utilityMeterReading(){
        return $this->hasMany(UtilityMeterReading::class);
    }

    public function formula(){
        return $this->belongsToMany(Formula::class);
    }
}
