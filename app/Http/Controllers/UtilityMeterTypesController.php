<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UtilityMeterType;

abstract class UtilityMeterTypesController extends Controller
{
    /**
     * Return all avialable utility meters list as [key => value]
     */
    public static function getListOfUtilityMeters(){
        $utility_meters = UtilityMeterType::all();
        $utility_meters_tab = array(
            '0' => 'Choose utility meter type'
        );

        foreach($utility_meters as $utility_meter){
            $utility_meters_tab[$utility_meter->id] = $utility_meter->type_name.' | ['.$utility_meter->unit->HTML_entity.']';
        }

        return $utility_meters_tab;
    }
}
