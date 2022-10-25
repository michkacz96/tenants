<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Formula;

class FormulasController extends Controller
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

    public static function getListOfFormulas(){
        $formulas = Formula::where('user_id', auth()->user()->id)->get();
        $formulas_tab = array(
            '0' => 'Choose formula'
        );
        foreach($formulas as $formula){
            $formulas_tab[$formula->id] = $formula->name;
        }

        return $formulas_tab;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = array(
            'title' => 'List of formulas',
            'formulas' => Formula::where('user_id', auth()->user()->id)->get()
        );
        return view('formulas.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = array(
            'title' => 'Add new formula',
            'utility_meters' => UtilityMeterTypesController::getListOfUtilityMeters(),
            'property_details' => PropertyDetailsController::getListOfPropertyDetils(),
            'formulas' => Formula::getListOfFormulas()
        );

        return view("formulas.create")->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {    
        if($request->input('meter') == 0 && $request->input('detail') == 0){
            return redirect('/formulas/create')->with('error', 'Choose property detail or utility meter');
        }elseif($request->input('formula') === 'um'){
            $full_formula = $request->input('formula').'('.$request->input('meter').')';
        } elseif($request->input('formula') === 'pd'){
            $full_formula = $request->input('formula').'('.$request->input('detail').')';
        }

        $formula = new Formula;
        $formula->user_id = auth()->user()->id;
        $formula->name = $request->input('name');
        $formula->formula = $full_formula;
        $formula->save();

        return redirect('/formulas')->with('success', 'Formula '.$formula->name.' added');
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
        $formula = Formula::find($id);
        $values = array(
            'um' => 0,
            'pd' => 0
        );

        if($formula->getDetail()['formula'] == 'um'){
            $values['um'] = $formula->getDetail()['id'];
        }elseif($formula->getDetail()['formula'] == 'pd'){
            $values['pd'] = $formula->getDetail()['id'];
        }

        $data = array(
            'title' => 'Edit formula '.$formula->name,
            'utility_meters' => UtilityMeterTypesController::getListOfUtilityMeters(),
            'property_details' => PropertyDetailsController::getListOfPropertyDetils(),
            'formulas' => Formula::getListOfFormulas(),
            'formula' => $formula,
            'formula_type' => $formula->getDetail()['formula'],
            'values' => $values
        );

        return view("formulas.edit")->with($data);
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
        $formula = Formula::find($id);

        if($formula->user_id !==  auth()->user()->id){
            return redirect('/formulas')->with('error', 'Unauthorized page');
        }else{
            if($request->input('meter') == 0 && $request->input('detail') == 0){
                return redirect('/formulas/create')->with('error', 'Choose property detail or utility meter');
            }elseif($request->input('formula') === 'um'){
                $full_formula = $request->input('formula').'('.$request->input('meter').')';
            } elseif($request->input('formula') === 'pd'){
                $full_formula = $request->input('formula').'('.$request->input('detail').')';
            }

            $formula->name = $request->input('name');
            $formula->formula = $full_formula;
            $formula->save();

            return redirect('/formulas')->with('success', 'Formula '.$formula->name.' edited');
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
        $formula = Formula::find($id);

        if($formula->user_id !==  auth()->user()->id){
            return redirect('/formulas')->with('error', 'Unauthorized page');
        }else{
            $formula->delete();
            return redirect('/formulas')->with('success', 'Formula '.$formula->name.' removed');
        }
    }
}
