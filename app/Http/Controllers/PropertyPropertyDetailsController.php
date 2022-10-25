<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Property;
use App\Models\PropertyDetail;
use App\Models\PropertyPropertyDetail;

class PropertyPropertyDetailsController extends Controller
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
     * Show the form for adding detail to current property
     *
     * @param  int  $id
     */
    public function addDetails($id)
    {
        $property = Property::find($id);

        if(auth()->user()->id !== $property->user_id){
            return redirect('/properties')->with('error', 'Unauthorized page');
        } else{
            $data = array(
                'title' => 'Add detail to property '.$property->getFullStreet(),
                'property' => $property,
                'listOfDetails' => PropertyDetailsController::getListOfPropertyDetils()
            );
    
            return view("properties.adddetail")->with($data);
        }
    }

    /**
     * Store a newly created detail in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param   property_id
     * @return \Illuminate\Http\Response
     */
    public function storeDetails(Request $request, $id)
    {
        $property = Property::find($id);

        if(auth()->user()->id !== $property->user_id){
            return redirect('/properties')->with('error', 'Unauthorized page');
        } else{
            $this->validate($request, [
                'detail' => 'required',
                'quantity' => 'required'
            ]);
    
            //create connection between property and property detail
            $propdet = new PropertyPropertyDetail;
            $propdet->property_id = $property->id;
            $propdet->property_detail_id = $request->input('detail');
            $propdet->quantity = $request->input('quantity');
            $propdet->detail_start_date = $request->input('start_date');
            $propdet->detail_end_date = $request->input('end_date');
    
            $propdet->save();
    
            return redirect('/properties/'.$property->id)->with('success', 'Detail added');
        }
    }

    /**
     * Show history of given property detail
     *
     * @param  int  $property_id
     * @param   int     $detail_id
     */
    public function showDetailsHistory($property_id, $detail_id)
    {
        $property = Property::find($property_id);
        $detail = PropertyDetail::find($detail_id);
        $prop_det = PropertyPropertyDetail::select()->where('property_detail_id', $detail_id)->orderBy('id', 'desc')->get();

        $tab = array();
        foreach($prop_det as $a){
            array_push($tab, $a->id);
        }

        if(auth()->user()->id !== $property->user_id){
            return redirect('/properties')->with('error', 'Unauthorized page');
        } else{
            if(auth()->user()->id !== $detail->user_id){
                return redirect('/properties')->with('error', 'Unauthorized page');
            } else{
                $data = array(
                    'title' => 'History of detail '.$detail->name.' at '.$property->getFullStreet(),
                    'property' => $property,
                    'details' => $property->propertyDetails->find($tab)
                );
        
                return view("properties.detailhistory")->with($data);
            }
        }
    }

    /**
     * Delete connection between property and property detail
     */
    public function deleteDetail($id){
        $detail_info = PropertyPropertyDetail::find($id);
        $property = Property::find($detail_info->property_id);

        //check for correct user and delete
        if(auth()->user()->id !== $property->user_id){
            return redirect('/properties')->with('error', 'Unauthorized page');
        } else{
            $detail_info->delete();
            return redirect('/properties/'.$property->id)->with('success', 'Detail removed');
        }
    }
}
