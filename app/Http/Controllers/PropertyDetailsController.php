<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PropertyDetail;
use App\Models\Unit;

class PropertyDetailsController extends Controller
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
     * Return list of avaiable details as [key => value]
     */
    public static function getListOfPropertyDetils(){
        $propertyDetails = PropertyDetail::select('id', 'unit_id', 'name')->where('user_id', auth()->user()->id)->get();
        $property_details_tab = array(
            '0' => 'Choose property detail'
        );
        foreach($propertyDetails as $propertyDetail){
            $property_details_tab[$propertyDetail->id] = $propertyDetail->name.' | '.Unit::getUnitEntity($propertyDetail->unit_id);
        }

        return $property_details_tab;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = array(
            'title' => 'List of possible details',
            'details' => PropertyDetail::where('user_id', auth()->user()->id)->get()
        );
        return view('propdetails.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = array(
            'title' => 'Add new property detail',
            'units' => UnitsController::getHtmlListOfUnits()
        );

        return view("propdetails.create")->with($data);
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
            'name' => 'required',
            'unit' => 'required'
        ]);

        //create property
        $property = new PropertyDetail;
        $property->user_id = auth()->user()->id;
        $property->unit_id = $request->input('unit');
        $property->name = $request->input('name');

        $property->save();

        return redirect('/propdetails')->with('success', $property->name.' added');
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
        $detail = PropertyDetail::find($id);
        if(auth()->user()->id !== $detail->user_id){
            return redirect('/propdetails')->with('error', 'Unauthorized page');
        } else{
            $data = array(
                'title' => 'Edit property detail: ',
                'units' => UnitsController::getHtmlListOfUnits(),
                'detail' => $detail
            );

            return view("propdetails.edit")->with($data);
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
        $detail = PropertyDetail::find($id);
        if(auth()->user()->id !== $detail->user_id){
            return redirect('/propdetails')->with('error', 'Unauthorized page');
        } else{
            $this->validate($request, [
                'name' => 'required',
                'unit' => 'required'
            ]);
    
            //edit property detail
            $detail->unit_id = $request->input('unit');
            $detail->name = $request->input('name');
    
            $detail->save();
    
            return redirect('/propdetails')->with('success', $detail->name.' edited');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $detail = PropertyDetail::find($id);

        //check for correct user and delete
        if(auth()->user()->id !== $detail->user_id){
            return redirect('/propdetails')->with('error', 'Unauthorized page');
        } else{
            $detail->delete();
        return redirect('/propdetails')->with('success', $detail->name.' removed');
        }
    }
}
