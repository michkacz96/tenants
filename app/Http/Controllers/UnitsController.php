<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Unit;

abstract class UnitsController extends Controller
{
    /**
     * Return all avialable unit list as [key => value] only HTML Entities
     */
    public static function getHtmlListOfUnits(){
        $units = Unit::all('id', 'HTML_entity');
        $tmp = [];
        foreach($units as $unit){
            $tmp[$unit->id] = $unit->HTML_entity;
        }

        return $tmp;
    }
}
