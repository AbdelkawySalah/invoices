<?php

namespace App\Http\Controllers;

use App\Models\invoices_details;
use Illuminate\Http\Request;

use App\Models\Invoices;
use App\Models\invoice_attachments;
use Illuminate\Support\Facades\Storage;
use File;

use App\Models\User;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\DB;

class InvoicesDetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
     * @param  \App\Models\invoices_details  $invoices_details
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
       // echo $id;
    //    $invoices=Invoices::findOrFail($id);
    //لما اعوز اجيب بيانات لحاجه ملهاش اكتر من صف يعني ليها صف واحد بس استخدم first
        $invoices=Invoices::where('id',$id)->first();
        //لما اعوز اجيب بيانات لحاجة ليها اكثر من صف يعني هتعمل لو عليها استخدم get
        $deatils=invoices_details::where('id_Invoice',$id)->get();
        $attachments=invoice_attachments::where('invoice_id',$id)->get();
    
          //عشان افضي جدول الاشعارات الخاصه باشعار معين
           DB::table("notifications")->where('data->id',$id)->delete();
            // return back();
        // }


        return view('invoices.details_invoices',compact('invoices','deatils','attachments'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\invoices_details  $invoices_details
     * @return \Illuminate\Http\Response
     */
    public function edit(invoices_details $invoices_details)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\invoices_details  $invoices_details
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, invoices_details $invoices_details)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\invoices_details  $invoices_details
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //
  //return $request;
    // $myFile=$request->invoice_number.'/'.$request->file_name;
    // return $myFile; 
     $invoices=invoice_attachments::findOrFail($request->id_file)->delete();
     Storage::disk('public_uploads')->delete($request->invoice_number.'/'.$request->file_name);
     session()->flash('delete', 'تم حذف المرفق بنجاح');
     return back();
    }

    public function OpenFile($invoice_number,$file_name)

    {
        $files = Storage::disk('public_uploads')->getDriver()->getAdapter()->applyPathPrefix($invoice_number.'/'.$file_name);
        return response()->file($files);
    }

    public function DownloadFile($invoice_number,$file_name)

    {
        $contents= Storage::disk('public_uploads')->getDriver()->getAdapter()->applyPathPrefix($invoice_number.'/'.$file_name);
        return response()->download( $contents);
    }


   

}
