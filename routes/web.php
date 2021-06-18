<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
 use App\Http\Controllers\InvoicesController;
 use App\Http\Controllers\SectionsController;
 use App\Http\Controllers\ProductsController;
 use App\Http\Controllers\InvoicesDetailsController;
 use App\Http\Controllers\InvoiceAttachmentsController;
 use App\Http\Controllers\invoiceAchiveController;
 use App\Http\Controllers\InvoicesReportController;
 use App\Http\Controllers\CustomerReportController;
 use App\Http\Controllers\UserController;
 use App\Http\Controllers\RoleController;
 use App\Http\Controllers\CustomersController;

 use Illuminate\Support\Facades\Auth;

 
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
//     return view('welcome');
// });


// عاوز بعد مستخدم ميعمل login 
// ويدخل لو ضغط علي 
// 127.0.0.1/8000
// ميودهوش علي login
Route::group(['middleware'=>['guest']],function(){
    Route::get('/',function(){
        return view('auth.login');
    });
   });

// Route::get('/',function(){
//     return view('auth.login');
// });

Auth::routes();
Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index']);


//Route::get('/{page}', 'AdminController@index');

Route::resource('invoices',InvoicesController::class);
Route::resource('sections',SectionsController::class);
Route::resource('products',ProductsController::class);
Route::get('/section/{id}',[InvoicesController::class,"getproducts"]);
Route::resource('invoicesDetails',InvoicesDetailsController::class);
Route::resource('InvoiceAttachments',InvoiceAttachmentsController::class);

Route::get('View_file/{invoice_number}/{file_name}',[InvoicesDetailsController::class,"OpenFile"]);
Route::get('download/{invoice_number}/{file_name}',[InvoicesDetailsController::class,"DownloadFile"]);
Route::post('delete_file',[InvoicesDetailsController::class,"destroy"]);
Route::get('edit_invoice/{id}',[InvoicesController::class,"edit"]);
Route::get('Status_show/{id}',[InvoicesController::class,"show"])->name('Status_show');
Route::post('status_update/{id}',[InvoicesController::class,"status_update"])->name('status_update');
//Route::post('status_update',[InvoicesController::class,"status_update"])->name('status_update');

Route::get('invoices_paid',[InvoicesController::class,"invoices_paid"])->name('invoices_paid');
Route::get('invoices_unpaid',[InvoicesController::class,"invoices_unpaid"])->name('invoices_unpaid');
Route::get('invoices_partailpaid',[InvoicesController::class,"invoices_partailpaid"])->name('invoices_partailpaid');
Route::resource('invoicesArchive',invoiceAchiveController::class);
Route::get('Print_invoice/{id}',[InvoicesController::class,"Print_invoice"])->name('Print_invoice');
Route::get('export_invoices', [InvoicesController::class,"export"]);
// Route::get('MarkAsRead_all',[InvoicesController::class,"MarkAsRead_all"])->name('MarkAsRead_all');

Route::get('/MarkAsRead_all',[InvoicesController::class,"MarkAsRead_all"])->name('MarkAsRead_all');

Route::resource('customers',CustomersController::class);

Route::group(['middleware' => ['auth']], function() {

    Route::resource('roles',RoleController::class);
    
    Route::resource('users',UserController::class);
    
    });
Route::get('invoicesReports',[InvoicesReportController::class,'index']);
Route::post('Search_invoices',[InvoicesReportController::class,'Search_invoices']);

//customer Reports
Route::get('CustomerReports',[CustomerReportController::class,'index']);
Route::post('Search_customers',[CustomerReportController::class,'Search_customers']);
Route::get('/section_rpt/{id}',[CustomerReportController::class,"getproducts"]);



// Route::resource('invoicesArchive',[invoiceAchiveController::class,"update"])->name('invoicesArchive');

// Route::get('Status_show/{id}', 'InvoicesController@show')->name('Status_show');

//Route::post('delete_file',[InvoicesDetailsController::class,"destroy"]);


//Route::get('/invoicesDetails/{id}',[InvoicesDetailsController::class,"show"]);
//Route::get('/section/{id}', 'InvoicesController@getproducts');

// Route::get('invoices',InvoicesController::class)->only([
//     'index','show'
// ]);
//Auth::routes();
//Auth::routes(['register'=>false]);

Route::get('/{page}', [AdminController::class,'index']);

// Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
//     return view('dashboard');
// })->name('dashboard');


