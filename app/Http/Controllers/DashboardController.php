<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\PurchasesController;
use App\Http\Controllers\SellItemsController;
use App\Models\VisualData;
use Illuminate\Support\Facades\DB;


class DashboardController extends Controller
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
     * Return comparaon fo sales and purchases to show in the graph
     */
    public function getSalesPurchasesChart(){
        $sum_purchases = DB::table('purchase_documents')
        ->select(DB::raw('sum(purchase_documents.amount) *-1 as sum'))
        ->where('purchase_documents.user_id', '=', auth()->user()->id)
        ->whereNull('purchase_documents.deleted_at')
        ->get();

        $sum_sales = DB::table('sell_documents')
        ->select(DB::raw('sum(sell_documents.total_amount) as sum'))
        ->where('sell_documents.user_id', '=', auth()->user()->id)
        ->whereNull('sell_documents.deleted_at')
        ->get();

        $vis = new VisualData;
        $vis->setType('pie');

        $vis->setLabels('Total purchases');
        $vis->setLabels('Total sales');
        

        $vis->setDiagramLabel('Sales vs. purchases');

        $vis->setData($sum_purchases[0]->sum);
        $vis->setData($sum_sales[0]->sum);
        

        $vis->showLegend();
  
        return $vis->generate(); 
    }

    /**
     * Return comparaon fo sales and purchases to show in the graph
     */
    public function getSalesPurchases(){
        $sum_purchases = DB::table('purchase_documents')
        ->select(DB::raw('sum(purchase_documents.amount) * -1 as sum'))
        ->where('purchase_documents.user_id', '=', auth()->user()->id)
        ->whereNull('purchase_documents.deleted_at')
        ->get();

        $sum_sales = DB::table('sell_documents')
        ->select(DB::raw('sum(sell_documents.total_amount) as sum'))
        ->where('sell_documents.user_id', '=', auth()->user()->id)
        ->whereNull('sell_documents.deleted_at')
        ->get();
        
        
        $finantial_result = $sum_sales[0]->sum + $sum_purchases[0]->sum;
        $finantial_result = number_format($finantial_result, 2, '.', '');
        if($finantial_result == null){
            $finantial_result = 0;
        }

        if($sum_purchases[0]->sum == null){
            $sum_purchases[0]->sum = number_format(0, 2, '.', '');
        } else{
            $sum_purchases[0]->sum = number_format($sum_purchases[0]->sum, 2, '.', '');
        }

        if($sum_sales[0]->sum == null){
            $sum_sales[0]->sum = number_format(0, 2, '.', '');
        } else{
            $sum_sales[0]->sum = number_format($sum_sales[0]->sum, 2, '.', '');
        }

        

        $tab = array(
            'Total purchases' => $sum_purchases[0]->sum,
            'Total sales' => $sum_sales[0]->sum,
            'Financial result' => $finantial_result
        );

        return $tab;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data = array(
            'title' => 'Hello '.auth()->user()->name.'!',
            'chart_purchases' => PurchasesController::getPurchasesChart(),
            'tab_purchases' => PurchasesController::getPurchases(),
            'chart_sales' => SellItemsController::getSalesChart(),
            'tab_sales' => SellItemsController::getSales(),
            'sales_vs_purchases' => $this->getSalesPurchasesChart(),
            'tab_sales_vs_purchases' => $this->getSalesPurchases()
        );
        return view('dashboard')->with($data);
    }
}
