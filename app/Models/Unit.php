<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Unit extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function PropertyDetail(){
        return $this->hasMany(PropertyDetail::class);
    }

    public function UtilityMeterType(){
        return $this->hasMany(UtilityMeterType::class);
    }

    public function UtilityMeterReading(){
        return $this->hasMany(UtilityMeterReading::class);
    }

    /**
     * Return HTML Entity of unit's given ID
     */
    public static function getUnitEntity($id){
        $unit = self::find($id);
        return $unit->HTML_entity;
    }

    /**
     * Return blank if date is 1000-01-01 or 9999-12-31 or null
     */
    public static function checkBlankDate($date){
        if($date == '1000-01-01' || $date == '9999-12-31' || $date == null){
            return null;
        } else{
            return $date;
        }
    }
}
