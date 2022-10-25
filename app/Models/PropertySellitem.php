<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Property;
use App\Models\Formula;
use App\Models\PropertyPropertyDetail;
use App\Models\SellDocument;

class PropertySellitem extends Model
{
    use HasFactory;

    protected $table = 'property_sell_item';

    public function formula(){
        return $this->hasMany(Formula::class);
    }

    public static function calculateQuantity($property_sellitem_id, SellDocument $document){
        $property_sellitem = self::find($property_sellitem_id);
        $formula = Formula::getDetailId($property_sellitem->formula_id);
        $year = $document->invoicing_year;
        $month = $document->invoicing_month;;
        $start_date = date('Y-m-d',strtotime(date('Y-'.$month.'-01')));
        $end_date = date('Y-m-t',strtotime($start_date));
        $days = round((strtotime($end_date) - strtotime($start_date)) / (60*60*24) +1);
        //echo $start_date.' | '.$end_date;
        
        if($formula['formula'] == 'um'){
            //utility meter value
            
        }elseif($formula['formula'] == 'pd'){
            //property detail value
            $details = PropertyPropertyDetail::where('property_id', '=', $property_sellitem->property_id)
            ->where('property_detail_id', '=', $formula['id'])
            //->whereNull('detail_end_date')
            ->orWhereNull('detail_end_date')
            ->where('detail_start_date', '<=', $start_date)
            ->where('detail_end_date', '>=', $end_date)
            ->orderBy('detail_start_date', 'desc')
            ->get();

            $quantity = 0.0000;

            if(isset($details)){
                if(count((is_countable($details)?$details:[]))){
                    foreach($details as $detail){
                        if($detail->detail_end_date === NULL){
                            if($detail->detail_start_date <= $start_date){
                                $quantity += $detail->quantity * round(round((strtotime($end_date) - strtotime($start_date)) / (60*60*24) +1) / $days, 4);
                            }else{
                                $quantity += $detail->quantity * round(round((strtotime($end_date) - strtotime($detail->detail_start_date)) / (60*60*24) +1) / $days, 4);
                            }  
                        }elseif($detail->detail_start_date >= $start_date && $detail->detail_end_date <= $end_date){
                            $quantity += $detail->quantity * round(round((strtotime($detail->detail_end_date) - strtotime($detail->detail_start_date)) / (60*60*24) +1) / $days, 4);
                        } elseif($detail->detail_start_date < $start_date){
                            $quantity += $detail->quantity * round(round((strtotime($detail->detail_end_date) - strtotime($start_date)) / (60*60*24) +1) / $days, 4);
                        }
                        
                    }
                }

                return round($quantity, 4);
            }else{
                return 0;
            }
        }

        
    }
}
