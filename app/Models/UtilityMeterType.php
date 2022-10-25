<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UtilityMeterType extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function unit(){
        return $this->belongsTo(Unit::class);
    }

    public function utilityMeter(){
        return $this->hasMany(utilityMeter::class);
    }
}
