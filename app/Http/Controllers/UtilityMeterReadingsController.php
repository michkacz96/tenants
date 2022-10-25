<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\UtilityMeter;
use App\Models\UtilityMeterReading;

class UtilityMeterReadingsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function addReading($utility_meter_id){
        $utility_meter = UtilityMeter::find($utility_meter_id);

        if($utility_meter->user_id !== auth()->user()->id){
            return redirect('/utilitymeters')->with('error', 'Unauthorized page');
        } else{
            $data = array(
                'title' => 'Add reading for '.$utility_meter->utilityMeterType->type_name.' s/n: '.$utility_meter->serial_number,
                'utility_meter' => $utility_meter
            );
            return view('utilitymeters.addreading')->with($data);
        }
    }

    public function storeReading(Request $request, $utility_meter_id){
        $utility_meter = UtilityMeter::find($utility_meter_id);

        if($utility_meter->user_id !== auth()->user()->id){
            return redirect('/utilitymeters')->with('error', 'Unauthorized page');
        } else{
            $this->validate($request, [
                'date' => 'required',
                'reading' => 'required'
            ]);

            if(UtilityMeterReading::where('reading_date', '=', $request->input('date'))->where('utility_meter_id', '=', $utility_meter->id)->count() != 0){
                return redirect('/utilitymeters/'.$utility_meter->id.'/addreading')->with('error', 'Reading for date '.$request->input('date').' exists already');
            } else{
                //create reading
                $reading = new UtilityMeterReading;
                $reading->utility_meter_id = $utility_meter->id;
                $reading->reading_date = $request->input('date');
                $reading->reading = $request->input('reading');
        
                $reading->save();
        
                return redirect('/utilitymeters')->with('success', 'Reading added to '.$utility_meter->utilityMeterType->type_name.' s/n: '.$utility_meter->serial_number);
            }
    
            
        }
    }

    public function showReadings($utility_meter_id){
        $utility_meter = UtilityMeter::find($utility_meter_id);

        if($utility_meter->user_id !== auth()->user()->id){
            return redirect('/utilitymeters')->with('error', 'Unauthorized page');
        } else{
            $data = array(
                'title' => 'Readings of '.$utility_meter->utilityMeterType->type_name.' s/n: '.$utility_meter->serial_number,
                'utility_meter' => $utility_meter,
                'readings' => UtilityMeterReading::select()->where('utility_meter_id', $utility_meter->id)->orderBy('reading_date', 'asc')->get()
            );
            return view('utilitymeters.readings')->with($data);
        }
    }

    public function editReading($reading_id){
        $reading = UtilityMeterReading::find($reading_id);
        $utility_meter = UtilityMeter::find($reading->utility_meter_id);

        if($utility_meter->user_id !== auth()->user()->id){
            return redirect('/utilitymeters')->with('error', 'Unauthorized page');
        } else{
            $data = array(
                'title' => 'Edit reading for '.$utility_meter->utilityMeterType->type_name.' s/n: '.$utility_meter->serial_number,
                'utility_meter' => $utility_meter,
                'reading' => $reading
            );
            return view('utilitymeters.editreading')->with($data);
        }
    }

    public function updateReading(Request $request, $reading_id){
        $reading = UtilityMeterReading::find($reading_id);
        $utility_meter = UtilityMeter::find($reading->utility_meter_id);

        if($utility_meter->user_id !== auth()->user()->id){
            return redirect('/utilitymeters')->with('error', 'Unauthorized page');
        } else{
            $this->validate($request, [
                'date' => 'required',
                'reading' => 'required'
            ]);

            //update reading
            $reading->reading_date = $request->input('date');
            $reading->reading = $request->input('reading');

            $reading->save();

            return redirect('/utilitymeters')->with('success', 'Reading edited in '.$utility_meter->utilityMeterType->type_name.' s/n: '.$utility_meter->serial_number);
            
        }
    }

    public function deleteReading($reading_id){
        $reading = UtilityMeterReading::find($reading_id);
        $utility_meter = UtilityMeter::find($reading->utility_meter_id);

        if($utility_meter->user_id !== auth()->user()->id){
            return redirect('/utilitymeters')->with('error', 'Unauthorized page');
        } else{
            $reading->delete();
            return redirect('/utilitymeters')->with('success', 'Reading removed');
        }
    }
}
