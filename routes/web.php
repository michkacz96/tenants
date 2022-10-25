<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomePagesController;
use App\Http\Controllers\PropertiesController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\SellItemsController;
use App\Http\Controllers\SuppliersController;
use App\Http\Controllers\TenantsController;
use App\Http\Controllers\PurchasesController;
use App\Http\Controllers\PropertyDetailsController;
use App\Http\Controllers\RentsController;
use App\Http\Controllers\PropertyPropertyDetailsController;
use App\Http\Controllers\UtilityMetersController;
use App\Http\Controllers\UtilityMeterReadingsController;
use App\Http\Controllers\FormulasController;
use App\Http\Controllers\PropertySellitemsController;
use App\Http\Controllers\SellDocumentsController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('home.index');
// });
// Route::get('/about', function () {
//     return view('home.about');
// });
// Route::get('/solutions', function () {
//     return view('home.solutions');
// });
// Route::get('/pricing', function () {
//     return view('home.pricing');
// });
$prefix = '';
Auth::routes();

Route::get($prefix.'/', [HomePagesController::class, 'index']);
Route::get($prefix.'/about', [HomePagesController::class, 'about']);
Route::get($prefix.'/pricing', [HomePagesController::class, 'pricing']);

Route::get($prefix.'/dashboard', [App\Http\Controllers\DashboardController::class, 'index']);

//Default routes for Properties
Route::get($prefix.'/properties/{property}/adddetail', [PropertyPropertyDetailsController::class, 'addDetails']);
Route::post($prefix.'/properties/{property}', [PropertyPropertyDetailsController::class, 'storeDetails']);
Route::get($prefix.'/properties/{property}/detailhistory/{propertydetail}', [PropertyPropertyDetailsController::class, 'showDetailsHistory']);
Route::delete($prefix.'/properties/detail/{propertydetail}', [PropertyPropertyDetailsController::class, 'deleteDetail']);
Route::resource($prefix.'properties', PropertiesController::class);

//Default routes for Categories
Route::resource($prefix.'categories', CategoriesController::class);

//Default routes for Goods and services (seel items)
Route::resource($prefix.'items', SellItemsController::class);

//Default routes for suppliers
Route::resource($prefix.'suppliers', SuppliersController::class);

//Default routes for tenants
Route::resource($prefix.'tenants', TenantsController::class);

//Default routes for purchase documents
Route::resource($prefix.'purchases', PurchasesController::class);

//Default routes for properties details
Route::resource($prefix.'propdetails', PropertyDetailsController::class);

//Default routes for utility meters
Route::resource($prefix.'utilitymeters', UtilityMetersController::class);

//Default routes for formulas
Route::resource($prefix.'formulas', FormulasController::class);

//Routes for rent controller 
//change tenant - display page with list of tenants
Route::get($prefix.'/properties/{property}/changetenant', [RentsController::class, 'changeTenantPage']);
Route::post($prefix.'/properties/{property}/changetenant', [RentsController::class, 'changeTenant']);
Route::delete($prefix.'/properties/{id}/deleterecord', [RentsController::class, 'deleteRecord']);
Route::match(['put', 'patch'], $prefix.'/properties/updaterecord/{id}', [RentsController::class, 'updateRecord']);
Route::get($prefix.'/properties/{id}/editrecord', [RentsController::class, 'editRecord']);

//Routes for readings of utility readers
Route::get($prefix.'/utilitymeters/{utilitymeter}/addreading', [UtilityMeterReadingsController::class, 'addReading']);
Route::post($prefix.'/utilitymeters/{utilitymeter}/addreading', [UtilityMeterReadingsController::class, 'storeReading']);
Route::get($prefix.'/utilitymeters/{utilitymeter}/readings', [UtilityMeterReadingsController::class, 'showReadings']);
Route::get($prefix.'/utilitymeters/{reading_id}/editreading', [UtilityMeterReadingsController::class, 'editReading']);
Route::delete($prefix.'/utilitymeters/deletereading/{reading_id}', [UtilityMeterReadingsController::class, 'deleteReading']);
Route::match(['put', 'patch'], $prefix.'/utilitymeters/updatereading/{reading_id}', [UtilityMeterReadingsController::class, 'updateReading']);

//create invoice for tenant
Route::get($prefix.'/properties/{property_id}/createinvoice', [RentsController::class, 'createInvoice']);
Route::post($prefix.'/properties/{property_id}/createinvoice', [RentsController::class, 'storeInvoice']);
Route::post($prefix.'/properties/{property_id}/invoicedetails', [RentsController::class, 'storeInvoiceDetails']);
Route::resource($prefix.'sales', SellDocumentsController::class);

//Roues for sell items and properties connection
Route::get($prefix.'/properties/{property_id}/additem', [PropertySellitemsController::class, 'addInvoiceItem']);
Route::post($prefix.'/properties/{property_id}/additem', [PropertySellitemsController::class, 'connectInvoiceItem']);