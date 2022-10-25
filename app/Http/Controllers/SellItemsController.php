<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SellItem;
use App\Models\VisualData;
use Illuminate\Support\Facades\DB;

class SellItemsController extends Controller
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
     * Return table of sales in categories
     */
    public static function getSales(){
        $data = DB::table('sell_document_details')
        ->select('sell_document_details.item_name as item', DB::raw('sum(sell_document_details.amount) as amount'))
        ->join('sell_documents', 'sell_documents.id', '=', 'sell_document_details.sell_document_id')
        ->where('sell_documents.user_id', '=', auth()->user()->id)
        ->whereNull('sell_documents.deleted_at')
        ->groupBy('item')
        ->get();

        $tab = array();
        
        foreach($data as $a){
            $tab[$a->item] = [$a->amount];
        }

        return $tab;
    }

    /**
     * Create JS class of purchase data to display
     */
    public static function getSalesChart(){
        $data = DB::table('sell_document_details')
        ->select('sell_document_details.item_name as item', DB::raw('sum(sell_document_details.amount) as amount'))
        ->join('sell_documents', 'sell_documents.id', '=', 'sell_document_details.sell_document_id')
        ->where('sell_documents.user_id', '=', auth()->user()->id)
        ->whereNull('sell_documents.deleted_at')
        ->groupBy('item')
        ->get();

        $vis = new VisualData;
        $vis->setType('bar');
        foreach($data as $cat){
            $vis->setLabels($cat->item);
        }
        $vis->setDiagramLabel('Sales');

        foreach($data as $amount){
            $vis->setData($amount->amount);
        }

        //return json_encode($vis);
        //return $data[0]->categories;   
        return $vis->generate();  
    }

    public static function getListOfSellItems(){
        $sellitems = SellItem::where('user_id', auth()->user()->id)->get();
        $sellitems_tab = array(
            '0' => 'Choose item'
        );
        foreach($sellitems as $sellitem){
            $sellitems_tab[$sellitem->id] = $sellitem->item_name;
        }

        return $sellitems_tab;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = array(
            'title' => 'List of goods and services',
            'sellitems' => SellItem::where('user_id', auth()->user()->id)->orderBy('item_name', 'asc')->get()
        );
        return view('items.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = array(
            'title' => 'Add new good or service',
            'categories' => CategoriesController::getListOfCategories()
        );

        return view("items.create")->with($data);
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
            'item_name' => 'required',
            'category' => 'required'
        ]);

        //create category
        $sellitem = new SellItem;
        $sellitem->item_name = $request->input('item_name');
        $sellitem->category_id = $request->input('category');
        $sellitem->user_id = auth()->user()->id;

        $sellitem->save();

        return redirect('/items')->with('success', 'Item '.$sellitem->item_name.' added');
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
        $sellitem = SellItem::find($id);
        $data = array(
            'title' => 'Edit',
            'categories' => CategoriesController::getListOfCategories(),
            'sellitem' => $sellitem
        );

        return view("items.edit")->with($data);
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
            'item_name' => 'required',
            'category' => 'required'
        ]);

        //create category
        $sellitem = SellItem::find($id);
        $sellitem->item_name = $request->input('item_name');
        $sellitem->category_id = $request->input('category');
        //$sellitem->user_id = auth()->user()->id;

        $sellitem->save();

        return redirect('/items')->with('success', 'Item '.$sellitem->item_name.' added');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $sellitem = SellItem::find($id);

        //check for correct user and delete
        if(auth()->user()->id !== $sellitem->user_id){
            return redirect('/items')->with('error', 'Unauthorized page');
        } else{
            $sellitem->delete();
            return redirect('/items')->with('success', 'Item '.$sellitem->item_name.' removed');
        }
    }
}
