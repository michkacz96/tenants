<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tenant;
use App\Models\Property;
use App\Models\PropertyTenant;
use App\Models\PropertyPropertyDetail;
use App\Models\SellDocument;
use App\Models\SellDocumentDetail;

class RentsController extends Controller
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

    public function changeTenantPage($property_id){
        $property = Property::find($property_id);
        
        $texts = array(
            'title' => 'Change tenant for '.$property->getFullStreet(),
            'no_find' => 'No previous tenants'
        );

        if($property->user_id !== auth()->user()->id){
            return redirect('/properties')->with('error', 'Unauthorized page');
        } else{
            $data = array(
                'texts' => $texts,
                'tenants' => TenantsController::getListOfTenants(),
                'property' => $property,
                'propten' => $property->tenants
            );
            return view('changetenants.changetenant')->with($data);
        }
        
    }

    public function changeTenant(Request $request, $property_id){
        $property = Property::find($property_id);

        if($property->user_id !== auth()->user()->id){
            return redirect('/properties')->with('error', 'Unauthorized page');
        } else{
            $this->validate($request, [
                'start_date' => 'required',
                'tenant' => 'required'
            ]);

            $tenant = Tenant::find($request->input('tenant'));
            $new_date = $request->input('start_date');
            $new_date_min1 = date('Y-m-d', strtotime($new_date.'-1 day'));
            $last_tenant = PropertyTenant::where('property_id', '=', $property->id)->orderBy('end_rent_date', 'ASC')->first();


            if($last_tenant === null){
                $tenancy = new PropertyTenant;
                $tenancy->property_id = $property->id;
                $tenancy->tenant_id = $request->input('tenant');
                $tenancy->start_rent_date = $request->input('start_date');
                $tenancy->end_rent_date = $request->input('end_date');
                $tenancy->save();
            }else{
                if($last_tenant->start_rent_date > $new_date){
                    return redirect('/properties/'.$property->id.'/changetenant')->with('error', 'Wrong start date');
                }else{
                    $tenancy = new PropertyTenant;
                    $tenancy->property_id = $property->id;
                    $tenancy->tenant_id = $request->input('tenant');
                    $tenancy->start_rent_date = $request->input('start_date');
                    $tenancy->end_rent_date = $request->input('end_date');
                    if($last_tenant->end_rent_date === NULL){
                        $last_tenant->end_rent_date = $new_date_min1;
                    }
                    $tenancy->save();
                    $last_tenant->save();
                }
            }   
    
            return redirect('/properties/'.$property->id)->with('success', 'Tenant changed at '.$property->getFullStreet());
        }
        
    }

    public function deleteRecord($id){
        $tenancy = PropertyTenant::find($id);
        $property = Property::find($tenancy->property_id);
        $tenant = Tenant::find($tenancy->tenant_id);

        if(($property->user_id !== auth()->user()->id) && ($tenant->user_id !== auth()->user()->id)){
            return redirect('/properties')->with('error', 'Unauthorized page');
        } else{
            $tenancy->delete();
            return redirect('/properties/'.$property->id)->with('success', 'Record removed');
        }
    }
    
    public function editRecord($id){
        $tenancy = PropertyTenant::find($id);
        $property = Property::find($tenancy->property_id);
        
        $texts = array(
            'title' => 'Change tenant for '.$property->getFullStreet(),
            'no_find' => 'No previous tenants'
        );

        if($property->user_id !== auth()->user()->id){
            return redirect('/properties')->with('error', 'Unauthorized page');
        } else{
            $data = array(
                'texts' => $texts,
                'tenants' => TenantsController::getListOfTenants(),
                'property' => $property,
                'propten' => $property->tenants,
                'tenancy' => $tenancy
            );
            return view('changetenants.editchangetenant')->with($data);
        }
    }
    public function updateRecord(Request $request, $id){
        $tenancy = PropertyTenant::find($id);
        $property = Property::find($tenancy->property_id);

        if($property->user_id !== auth()->user()->id){
            return redirect('/properties')->with('error', 'Unauthorized page');
        } else{
            $tenancy->tenant_id = $request->input('tenant');
            $tenancy->start_rent_date = $request->input('start_date');
            $tenancy->end_rent_date = $request->input('end_date');
            $tenancy->save();

            return redirect('/properties/'.$property->id)->with('success', 'Record edited');
        }
    }

    public function createInvoice($property_id){
        $property = Property::find($property_id);

        if($property->user_id !== auth()->user()->id){
            return redirect('/properties')->with('error', 'Unauthorized page');
        } else{
            if(isset($last_tenant->tenant_id)){
                $a = $last_tenant->tenant_id;
            } else{
                $a = 0;
            }

            $last_tenant = PropertyTenant::where('property_id', '=', $property->id)->orderBy('end_rent_date', 'ASC')->first();
            $data = array(
                'title' => 'Create new invoice',
                'tenants_list' => TenantsController::getListOfTenants(),
                'current_tenant' => $a,
                'property' => $property
            );
            return view('sales.createinvoice')->with($data);
        }
    }

    public function storeInvoice(Request $request, $property_id){
        $property = Property::find($property_id);

        if($property->user_id !== auth()->user()->id){
            return redirect('/properties')->with('error', 'Unauthorized page');
        } else{

            $sell_document = new SellDocument;
            $sell_document->property_id = $property->id;
            $sell_document->user_id = auth()->user()->id;
            $sell_document->tenant_id = $request->input('tenant');
            $sell_document->invoice_number = $request->input('invoice_number');
            $sell_document->invoicing_year = $request->input('invoicing_year');
            $sell_document->invoicing_month = $request->input('invoicing_month');
            $sell_document->invoice_date = $request->input('invoice_date');
            $sell_document->sell_date = $request->input('sell_date');
            $sell_document->due_date = $request->input('due_date');
            $sell_document->description = $request->input('description');

            $sell_document->save();

            $sellitems = $property->sellitems;

            $data = array(
                'title' => 'Details of invoice ('.$sell_document->invoice_number.')',
                'invoice' => $sell_document,
                'items' => $sellitems
            );

            return view('sales.createinvoicedetails')->with($data);
        }
    }

    public function storeInvoiceDetails(Request $request, $document_id){
        $document = SellDocument::find($document_id);

        if($document->user_id !== auth()->user()->id){
            return redirect('/properties')->with('error', 'Unauthorized page');
        } else{
            $details = $request->input('invoice');

            $total_tax = 0.00;
            $total_amount = 0.00;
            //print_r($details); echo '<br><br>';
            foreach($details as $position){
                print_r($position); echo '<br>';

                $detail = new SellDocumentDetail;
                $detail->sell_document_id = $document->id;
                $detail->item_name = $position['item'];
                $detail->quantity = $position['quantity'];
                $detail->price = $position['unit_price'];
                $detail->tax = $position['tax'];
                $detail->tax_amount = $position['tax_amount'];
                $detail->amount = $position['amount'];

                $total_tax += $position['tax_amount'];
                $total_amount += $position['amount'];

                $detail->save();
            }

            $document->total_amount = $total_amount;
            $document->save();           


            return redirect('sales')->with('success', 'Invoice '.$document->invoice_number.' added');
        }
    }
}

  

    
