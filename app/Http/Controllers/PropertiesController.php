<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Property;
use App\Models\User;
use App\Models\Unit;
use App\Models\PropertyPropertyDetail;
use App\Models\PropertyDetail;
use DB;

class PropertiesController extends Controller
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
            'title' => 'List of properties',
            'properties' => Property::where('user_id', auth()->user()->id)->orderBy('street_name', 'asc')->orderBy('street_number', 'asc')->orderBy('apt_number', 'asc')->get()
        );
        return view('properties.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = array(
            'title' => 'Add new property'
        );

        return view("properties.create")->with($data);
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
            'street_name' => 'required',
            'street_number' => 'required',
            'zip_code' => 'required',
            'city' => 'required'
        ]);

        //create property
        $property = new Property;
        $property->street_name = $request->input('street_name');
        $property->street_number = $request->input('street_number');
        $property->apt_number = $request->input('apt_number');
        $property->zip_code = $request->input('zip_code');
        $property->city = $request->input('city');
        $property->state = $request->input('state');
        $property->user_id = auth()->user()->id;

        $property->save();

        return redirect('/properties')->with('success', 'Property added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $property = Property::find($id);
        $data = array(
            'title' => 'Details of',
            'full_address' => $property->getAddress(),
            'property' => $property,
            'details' => $property->propertyDetails,
            'propten' => $property->tenants,
            'sellitems' => $property->sellItems
        );

        return view("properties.show")->with($data); 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $property = Property::find($id);
        $data = array(
            'title' => 'Edit',
            'property' => $property
        );

        return view("properties.edit")->with($data);
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
            'street_name' => 'required',
            'street_number' => 'required',
            'zip_code' => 'required',
            'city' => 'required'
        ]);

        //create property
        $property = Property::find($id);
        $property->street_name = $request->input('street_name');
        $property->street_number = $request->input('street_number');
        $property->apt_number = $request->input('apt_number');
        $property->zip_code = $request->input('zip_code');
        $property->city = $request->input('city');
        $property->state = $request->input('state');
        //$property->user_id = auth()->user()->id;

        $property->save();

        return redirect('/properties')->with('success', 'Property updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $property = Property::find($id);

        //check for correct user and delete
        if(auth()->user()->id !== $property->user_id){
            return redirect('/properties')->with('error', 'Unauthorized page');
        } else{
            $property->delete();
            return redirect('/properties')->with('success', 'Property removed');
        }
    }   
    
    /**
     * Return all avialable properties list as [key => value]
     */
    public static function getListOfProperties(){
        $properties = Property::where('user_id', auth()->user()->id)->orderBy('street_name', 'asc')->orderBy('street_number', 'asc')->orderBy('apt_number', 'asc')->get();
        $properties_tab = array();

        foreach($properties as $property){
            $properties_tab[$property->id] = $property->getAddress();
        }

        return $properties_tab;
    }
}
