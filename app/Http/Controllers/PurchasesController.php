<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PurchaseDocument;
use App\Models\VisualData;
use Illuminate\Support\Facades\DB;

class PurchasesController extends Controller
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

    public static function getPurchases(){
        $data = DB::table('purchase_documents')
        ->join('categories', 'purchase_documents.category_id', '=', 'categories.id')
        ->select('categories.category_name as categories', DB::raw('sum(purchase_documents.amount) *-1 as amounts'))
        ->where('purchase_documents.user_id', '=', auth()->user()->id)
        ->whereNull('purchase_documents.deleted_at')
        ->groupBy('categories')
        ->get();

        $tab = array();
        
        foreach($data as $a){
            $tab[$a->categories] = [$a->amounts];
        }

        return $tab;
    }

    /**
     * Create JS class of purchase data to display
     */
    public static function getPurchasesChart(){
        $data = DB::table('purchase_documents')
        ->join('categories', 'purchase_documents.category_id', '=', 'categories.id')
        ->select('categories.category_name as categories', DB::raw('sum(purchase_documents.amount) *-1 as amounts'))
        ->where('purchase_documents.user_id', '=', auth()->user()->id)
        ->whereNull('purchase_documents.deleted_at')
        ->groupBy('categories')
        ->get();

        $vis = new VisualData;
        $vis->setType('bar');
        foreach($data as $cat){
            $vis->setLabels($cat->categories);
        }
        $vis->setDiagramLabel('Purchases');

        foreach($data as $amount){
            $vis->setData($amount->amounts);
        }

        //return json_encode($vis);
        //return $data[0]->categories;   
        return $vis->generate();  
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = array(
            'title' => 'List of purchase documents',
            'documents' => PurchaseDocument::where('user_id', auth()->user()->id)->orderBy('invoice_date', 'asc')->get()
        );
        return view('purchases.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = array(
            'title' => 'Add new purchase document',
            'suppliers' => SuppliersController::getListOfSuppliers(),
            'categories' => CategoriesController::getListOfPurchaseCategories()
        );

        return view("purchases.create")->with($data);
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
            'supplier' => 'required',
            'category' => 'required',
            'invoice_number' => 'required',
            'invoice_date' => 'required',
            'due_date' => 'required',
            'sell_date' => 'required',
            'amount' => 'required'
        ]);

        //create property
        $document = new PurchaseDocument;
        $document->supplier_id = $request->input('supplier');
        $document->category_id = $request->input('category');
        $document->user_id = auth()->user()->id;
        $document->description = $request->input('description');
        $document->invoice_number = $request->input('invoice_number');
        $document->invoice_date = $request->input('invoice_date');
        $document->due_date = $request->input('due_date');
        $document->sell_date = $request->input('sell_date');
        $document->amount = $request->input('amount');

        $document->save();

        return redirect('/purchases')->with('success', 'Document '.$document->invoice_number.' added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $document = PurchaseDocument::find($id);

        if(auth()->user()->id !== $document->user_id){
            return redirect('/purchases')->with('error', 'Unauthorized page');
        } else{
            $data = array(
                'title' => 'Details of document: '.$document->invoice_number,
                'document' => $document
            );

            return view("purchases.show")->with($data);
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
        $document = PurchaseDocument::find($id);

        if(auth()->user()->id !== $document->user_id){
            return redirect('/purchases')->with('error', 'Unauthorized page');
        } else{
            $data = array(
                'title' => 'Edit document: '.$document->invoice_number,
                'categories' => CategoriesController::getListOfPurchaseCategories(),
                'suppliers' => SuppliersController::getListOfSuppliers(),
                'document' => $document
            );

            return view("purchases.edit")->with($data);
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
            'supplier' => 'required',
            'category' => 'required',
            'invoice_number' => 'required',
            'invoice_date' => 'required',
            'due_date' => 'required',
            'sell_date' => 'required',
            'amount' => 'required'
        ]);

        //create property
        $document = PurchaseDocument::find($id);
        if(auth()->user()->id !== $document->user_id){
            return redirect('/purchases')->with('error', 'Unauthorized page');
        } else{
            $document->supplier_id = $request->input('supplier');
            $document->category_id = $request->input('category');
            $document->description = $request->input('description');
            $document->invoice_number = $request->input('invoice_number');
            $document->invoice_date = $request->input('invoice_date');
            $document->due_date = $request->input('due_date');
            $document->sell_date = $request->input('sell_date');
            $document->amount = $request->input('amount');

            $document->save();

            return redirect('/purchases')->with('success', 'Document '.$document->invoice_number.' updated');
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
        $document = PurchaseDocument::find($id);

        //check for correct user and delete
        if(auth()->user()->id !== $document->user_id){
            return redirect('/purchases')->with('error', 'Unauthorized page');
        } else{
            $document->delete();
        return redirect('/purchases')->with('success', 'Document '.$document->invoice_number.' removed');
        }
    }
}
