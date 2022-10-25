<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Property;
use App\Models\PropertySellitem;
use App\Models\SellItem;

class PropertySellitemsController extends Controller
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

    public function addInvoiceItem($property_id){
        $property = Property::find($property_id);

        if($property->user_id !== auth()->user()->id){
            return redirect('/properties')->with('error', 'Unauthorized page');
        }
        $data = array(
            'title' => 'Add invoice item for '.$property->getAddress(),
            'sellitems' => SellItemsController::getListOfSellItems(),
            'formulas' => FormulasController::getListOfFormulas(),
            'property' => $property
        );
        return view('propertiessellitems.addsellitem')->with($data);
    }

    public function connectInvoiceItem(Request $request, $property_id){
        $property = Property::find($property_id);

        if($property->user_id !== auth()->user()->id){
            return redirect('/properties')->with('error', 'Unauthorized page');
        }else{
            $this->validate($request, [
                'sellitem' => 'required',
                'formula' => 'required',
                'start_date' => 'required'
            ]);
    
            //create connection
            $propitem = new PropertySellitem;
            $propitem->start_date = $request->input('start_date');
            $propitem->end_date = $request->input('end_date');
            $propitem->property_id = $property->id;
            $propitem->sell_item_id = $request->input('sellitem');
            $propitem->formula_id = $request->input('formula');
            $propitem->price = $request->input('price');
    
            $propitem->save();
    
            return redirect('/properties/'.$property->id)->with('success', 'Invoice item added');
        }
    }
}
