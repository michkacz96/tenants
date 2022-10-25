<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UtilityMeter;

class UtilityMetersController extends Controller
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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = array(
            'title' => 'List of utility meters',
            'utility_meters' => UtilityMeter::all()
        );
        return view('utilitymeters.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = array(
            'title' => 'Add new utility meter',
            'utility_meter_types' => UtilityMeterTypesController::getListOfUtilityMeters(),
            'properties' => PropertiesController::getListOfProperties()
        );
        return view('utilitymeters.create')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'serial_number' => 'required',
            'meter_type' => 'required',
            'property' => 'required'
        ]);

        //create property
        $utility_meter = new UtilityMeter;
        $utility_meter->user_id = auth()->user()->id;
        $utility_meter->property_id = $request->input('property');
        $utility_meter->utility_meter_type_id = $request->input('meter_type');
        $utility_meter->serial_number = $request->input('serial_number');
        $utility_meter->start_date = $request->input('start_date');
        $utility_meter->end_date = $request->input('end_date');

        $utility_meter->save();

        return redirect('/utilitymeters')->with('success', 'Utility meter s/n: '.$utility_meter->serial_number.' added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $utility_meter = UtilityMeter::find($id);

        if($utility_meter->user_id !== auth()->user()->id){
            return redirect('/utilitymeters')->with('error', 'Unauthorized page');
        } else{
            $data = array(
                'title' => 'Edit '.$utility_meter->utilityMeterType->type_name.' s/n: '.$utility_meter->serial_number,
                'utility_meter_types' => UtilityMeterTypesController::getListOfUtilityMeters(),
                'properties' => PropertiesController::getListOfProperties(),
                'utility_meter' => $utility_meter
            );

            return view('utilitymeters.edit')->with($data);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'serial_number' => 'required',
            'meter_type' => 'required',
            'property' => 'required'
        ]);

        $utility_meter = UtilityMeter::find($id);
        $utility_meter->property_id = $request->input('property');
        $utility_meter->utility_meter_type_id = $request->input('meter_type');
        $utility_meter->serial_number = $request->input('serial_number');
        $utility_meter->start_date = $request->input('start_date');
        $utility_meter->end_date = $request->input('end_date');

        $utility_meter->save();

        return redirect('/utilitymeters')->with('success', 'Utility meter s/n: '.$utility_meter->serial_number.' updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $utility_meter = UtilityMeter::find($id);

        //check for correct user and delete
        if(auth()->user()->id !== $utility_meter->user_id){
            return redirect('/utilitymeters')->with('error', 'Unauthorized page');
        } else{
            $utility_meter->delete();
            return redirect('/utilitymeters')->with('success', $utility_meter->utilityMeterType->type_name.' s/n: '.$utility_meter->serial_number.' removed');
        }
    }
}
