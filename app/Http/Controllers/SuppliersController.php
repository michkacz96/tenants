<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supplier;

class SuppliersController extends Controller
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
     * Return all avialable suppliers as [key => value]
     */
    public static function getListOfSuppliers(){
        $suppliers = Supplier::select('id', 'supplier_code', 'supplier_name')->where('user_id', auth()->user()->id)->get();
        $tmp = [];
        foreach($suppliers as $supplier){
            $tmp[$supplier->id] = $supplier->supplier_code.' | '.$supplier->supplier_name;
        }

        return $tmp;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = array(
            'title' => 'List of suppliers',
            'suppliers' => Supplier::where('user_id', auth()->user()->id)->orderBy('supplier_code', 'asc')->get()
        );
        return view('suppliers.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = array(
            'title' => 'Add new supplier'
        );
        return view('suppliers.create')->with($data);
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
            'supplier_code' => 'required',
            'supplier_name' => 'required'
        ]);

        //create supplier
        $supplier = new Supplier;
        $supplier->user_id = auth()->user()->id;
        $supplier->supplier_code = $request->input('supplier_code');
        $supplier->supplier_name = $request->input('supplier_name');
        $supplier->TIN = $request->input('TIN');
        $supplier->street_name = $request->input('street_name');
        $supplier->street_number = $request->input('street_number');
        $supplier->apt_number = $request->input('apt_number');
        $supplier->city = $request->input('city');
        $supplier->state = $request->input('state');
        $supplier->zip_code = $request->input('zip_code');
        $supplier->country = $request->input('country');
        $supplier->phone_number = $request->input('phone_number');
        $supplier->email = $request->input('email');
        $supplier->website = $request->input('website');

        $supplier->save();

        return redirect('/suppliers')->with('success', 'Supplier '.$supplier->supplier_name.' added');
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
        $supplier = Supplier::find($id);

        if($supplier->user_id !== auth()->user()->id){
            return redirect('/suppliers')->with('error', 'Unauthorized page');
        } else{
            $data = array(
                'title' => 'Edit '.$supplier->supplier_name,
                'supplier' => $supplier
            );

            return view('suppliers.edit')->with($data);
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
            'supplier_code' => 'required',
            'supplier_name' => 'required'
        ]);

        //create supplier
        $supplier = Supplier::find($id);

        if($supplier->user_id !== auth()->user()->id){
            return redirect('/suppliers')->with('error', 'Unauthorized page');
        } else{
            $supplier->user_id = auth()->user()->id;
            $supplier->supplier_name = $request->input('supplier_name');
            $supplier->supplier_code = $request->input('supplier_code');
            $supplier->TIN = $request->input('tax_number');
            $supplier->street_name = $request->input('street_name');
            $supplier->street_number = $request->input('street_number');
            $supplier->apt_number = $request->input('apt_number');
            $supplier->city = $request->input('city');
            $supplier->state = $request->input('state');
            $supplier->zip_code = $request->input('zip_code');
            $supplier->country = $request->input('country');
            $supplier->phone_number = $request->input('phone_number');
            $supplier->email = $request->input('email');
            $supplier->website = $request->input('website');
    
            $supplier->save();
    
            return redirect('/suppliers')->with('success', 'Supplier '.$supplier->supplier_name.' edited');
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
        $supplier = Supplier::find($id);

        //check for correct user and delete
        if(auth()->user()->id !== $supplier->user_id){
            return redirect('/suppliers')->with('error', 'Unauthorized page');
        } else{
            $supplier->delete();
            return redirect('/suppliers')->with('success', 'Supplier '.$supplier->supplier_name.' removed');
        }
    }
}
