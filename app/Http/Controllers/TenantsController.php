<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tenant;

class TenantsController extends Controller
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
     * Return all avialable tenants as [key => value]
     */
    public static function getListOfTenants(){
        $tenants = Tenant::select('id', 'tenant_code', 'tenant_name')->where('user_id', auth()->user()->id)->get();
        $tmp = [];
        foreach($tenants as $tenant){
            $tmp[$tenant->id] = $tenant->tenant_code.' | '.$tenant->tenant_name;
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
            'title' => 'List of tenants',
            'tenants' => Tenant::where('user_id', auth()->user()->id)->orderBy('tenant_code', 'asc')->get()
        );
        return view('tenants.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = array(
            'title' => 'Add new tenant'
        );
        return view('tenants.create')->with($data);
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
            'tenant_code' => 'required',
            'tenant_name' => 'required'
        ]);

        //create tenant
        $tenant = new Tenant;
        $tenant->user_id = auth()->user()->id;
        $tenant->tenant_code = $request->input('tenant_code');
        $tenant->tenant_name = $request->input('tenant_name');
        $tenant->TIN = $request->input('TIN');
        $tenant->street_name = $request->input('street_name');
        $tenant->street_number = $request->input('street_number');
        $tenant->apt_number = $request->input('apt_number');
        $tenant->city = $request->input('city');
        $tenant->state = $request->input('state');
        $tenant->zip_code = $request->input('zip_code');
        $tenant->country = $request->input('country');
        $tenant->phone_number = $request->input('phone_number');
        $tenant->email = $request->input('email');
        $tenant->website = $request->input('website');

        $tenant->save();

        return redirect('/tenants')->with('success', 'Tenat '.$tenant->tenant_name.' added');
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
        $tenant = Tenant::find($id);

        if($tenant->user_id !== auth()->user()->id){
            return redirect('/tenants')->with('error', 'Unauthorized page');
        } else{
            $data = array(
                'title' => 'Edit '.$tenant->tenant_name,
                'tenant' => $tenant
            );

            return view('tenants.edit')->with($data);
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
            'tenant_code' => 'required',
            'tenant_name' => 'required'
        ]);

        //create tenant
        $tenant = Tenant::find($id);

        if($tenant->user_id !== auth()->user()->id){
            return redirect('/tenants')->with('error', 'Unauthorized page');
        } else{
            $tenant->user_id = auth()->user()->id;
            $tenant->tenant_name = $request->input('tenant_name');
            $tenant->tenant_code = $request->input('tenant_code');
            $tenant->TIN = $request->input('tax_number');
            $tenant->street_name = $request->input('street_name');
            $tenant->street_number = $request->input('street_number');
            $tenant->apt_number = $request->input('apt_number');
            $tenant->city = $request->input('city');
            $tenant->state = $request->input('state');
            $tenant->zip_code = $request->input('zip_code');
            $tenant->country = $request->input('country');
            $tenant->phone_number = $request->input('phone_number');
            $tenant->email = $request->input('email');
            $tenant->website = $request->input('website');
    
            $tenant->save();
    
            return redirect('/tenants')->with('success', 'Tenant '.$tenant->tenant_name.' edited');
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
        $tenant = Tenant::find($id);

        //check for correct user and delete
        if(auth()->user()->id !== $tenant->user_id){
            return redirect('/tenants')->with('error', 'Unauthorized page');
        } else{
            $tenant->delete();
            return redirect('/tenants')->with('success', 'Tenant '.$tenant->tenant_name.' removed');
        }
    }
}
