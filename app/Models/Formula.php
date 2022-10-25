<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Formula extends Model
{
    use HasFactory;
    use SoftDeletes;

    static protected $formulas = array(
        'um' => 'Utility meter',
        'pd' => 'Property detail'
    );

    public static function getListOfFormulas(){
        return self::$formulas;
    }

    public function getDetail(){
        $formula = $this->formula;
        $formula_length = strlen($formula);
        
        $formula_txt = '';
        $formula_id = '';
        for($i = 0; $i < $formula_length; $i++){
            if(is_numeric($formula[$i])){
                $formula_id = $formula_id.$formula[$i];
            }elseif($formula[$i] == '(' || $formula[$i] == ')'){
                $formula_txt = $formula_txt;
            }else{
                $formula_txt = $formula_txt.$formula[$i];
            }
        }

        if(is_numeric($formula_id)){
            $formula_id = intval($formula_id);
        }

        $result = array(
            'formula' => $formula_txt,
            'id' => $formula_id
        );

        return $result;
    }

    public static function getName($id){
        $form = self::find($id);
        return $form->name;
    }

    public static function getFormula($id){
        $form = self::find($id);
        return $form->formula;
    }

    public static function getDetailId($id){
        $formula = self::find($id);
        return $formula->getDetail();
    }

    //datbase relations
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function propertyDetail(){
        return $this->belongsTo(PropertyDetail::class)->withTrashed();
    }

    public function utilityMeter(){
        return $this->belongsTo(PropertyDetail::class)->withTrashed();
    }

    public function propertySellitem(){
        return $this->hasMany(PropertySellitem::class);
    }
}
