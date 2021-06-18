<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoices;

class InvoicesReportController extends Controller
{
    //
    public function index(){
     $Invoices=Invoices::all();
    //   return $Invoices;
    // $details = Invoices::all();
     return view('reports.invoices_reports')->withDetails($Invoices);
    // 
    }


    public function Search_invoices(Request $request)
    {
        $rdio = $request->rdio;
      //  return $request;
    //    return $rdio;
        // في حالة البحث بنوع الفاتورة
           
           if ($rdio == 1) {
              
            // //في حالة انه اختار الكل  مع عدم اختيار تاريخ
            // if ($request->type='الكل' && $request->start_at =='' && $request->end_at =='') {
                   
            //     $invoices = Invoices::all();
            //  //  return $invoices;
            //     $type = 'الكل';
            //     return view('reports.invoices_reports',compact('type'))->withDetails($invoices);
            //  }
            //  //في حالة اختيار الكل مع اختيار الفترة
            //  elseif($request->type=='الكل' && $request->start_at !='' && $request->end_at !='')
            //    {
            //     $start_at = date($request->start_at);
            //      $end_at = date($request->end_at);
            //      $type = $request->type;
                 
            //      $invoices = Invoices::whereBetween('invoice_Date',[$start_at,$end_at])->get();
            //      return view('reports.invoices_reports',compact('type','start_at','end_at'))->withDetails($invoices);
                 
            //  }

    //=============================================
    //في حالة اذا كان اختار الكل هيعرض كل الفواتير غير كده هيختار نوع الفاتورة ويعرض
        // في حالة اختيار حالة الفاتورة مدفوعة او غير مفوعة عدم تحديد تاريخ
               if ($request->type && $request->start_at =='' && $request->end_at =='') {
           
            //لاختبار لو ضغط علي الكل 
                $type = $request->type;
                   if($type=='الكل'){
                    $invoices = Invoices::all();
                   }
                   else{
                    $invoices = Invoices::select('*')->where('Status','=',$request->type)->get();
                   }
               //  return $invoices;
                //   $type = $request->type;
                  return view('reports.invoices_reports',compact('type'))->withDetails($invoices);
             
                }
               
               // في حالة تحديد تاريخ استحقاق
               else {
                  
                 $start_at = date($request->start_at);
                 $end_at = date($request->end_at);
                 $type = $request->type;
                 //لو اختار كل هيعرض كل الفواتير في تاريه ده
                 if($type=='الكل')
                 {
                    $invoices = Invoices::whereBetween('invoice_Date',[$start_at,$end_at])->get();
                }
                else{
                    //مكنش يبقي هيختار الفواتير مدفوعة او غير دفوعة
                    $invoices = Invoices::whereBetween('invoice_Date',[$start_at,$end_at])->where('Status','=',$request->type)->get();
                }
                 return view('reports.invoices_reports',compact('type','start_at','end_at'))->withDetails($invoices);
                 
               }
       
        
               
           } 
           
       //====================================================================
           
       // في البحث برقم الفاتورة
           else {
               
               $invoices = Invoices::select('*')->where('invoice_number','=',$request->invoice_number)->get();
               return view('reports.invoices_reports')->withDetails($invoices);
               
           }
       
           
            
           }


        }

