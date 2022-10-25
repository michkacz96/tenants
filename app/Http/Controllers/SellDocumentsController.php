<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SellDocument;
use App\Models\SellDocumentDetail;
use App\Models\Tenant;
use App\Models\Property;

class SellDocumentsController extends Controller
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
        $texts = array(
            'title' => 'List of sales documents',
            'no_results' => 'No documents to show yet'
        );

        $data = array(
            'texts' => $texts,
            'documents' => SellDocument::all()
        );
        return view('sales.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return abort(404);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $document = SellDocument::find($id);

        if($document->user_id !== auth()->user()->id){
            return redirect('/properties')->with('error', 'Unauthorized page');
        } else{
            $details = SellDocumentDetail::where('sell_document_id', $document->id)->get();
            $tenant = Tenant::find($document->tenant_id);
            $property = Property::find($document->property_id);
            $property_description = 'Invoice for '.$property->getAddress();

            $data = array(
                'title' => 'Invoice '.$document->invoice_number,
                'document' => $document,
                'details' => $details,
                'tenant' => $tenant,
                'seller' => auth()->user(),
                'property' => $property_description
            );
            return view('sales.show')->with($data);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $document = SellDocument::find($id);

        //check for correct user and delete
        if(auth()->user()->id !== $document->user_id){
            return redirect('/sales')->with('error', 'Unauthorized page');
        } else{
            $document->delete();
            return redirect('/sales')->with('success', 'Document '.$document->invoice_number.' removed');
        }
    }
}
