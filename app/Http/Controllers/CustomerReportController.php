<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\sections;
use Illuminate\Support\Facades\DB;
use App\Models\Invoices;

class CustomerReportController extends Controller
{
    //
    public function index(){
        $sections=sections::all();
       return view('reports.customers_report',compact('sections'));
    }

  public function Search_customers(Request $request){
  // return $request;
  //عشان نجيب اسم القسم عشان لما نعمل اعادة تحميل لصفحة يجيب العنصر المختار
  $sectionnameT=sections::where('id',$request->Section)->first()->section_name;
  $sctionidT=$request->Section;
  // $sectType;
   $protype=$request->product;

// في حالة البحث بدون التاريخ
      
     if ($request->Section && $request->product && $request->start_at =='' && $request->end_at=='') 
     {
       
        $invoices = Invoices::select('*')->where('section_id','=',$request->Section)->where('product','=',$request->product)->get();
        $sections = sections::all();
      // return $protype;
      return view('reports.customers_report',compact('sections','sectionnameT','sctionidT','protype'))->withDetails($invoices);
       }

       // في حالة البحث بتاريخ
     
     else {
        // $sectType=sections::where('id',$request->Section)->first()->section_name;
        // $protype=$request->product;
        $start_at = date($request->start_at);
        $end_at = date($request->end_at);
 
       $invoices = Invoices::whereBetween('invoice_Date',[$start_at,$end_at])->where('section_id','=',$request->Section)->where('product','=',$request->product)->get();
     //  return $invoices;
       $sections = sections::all();
        return view('reports.customers_report',compact('sections','sectionnameT','sctionidT','protype','start_at','end_at'))->withDetails($invoices);
        //  return view('reports.customers_report',compact('sections'))->withDetails($invoices);
       
      }
      


         
    }


    public function getproducts($id){
        //  $products=products::where('section_id',$id)->pluck("product_name","id");
          $products=DB::table("products")->where("section_id",$id)->pluck("product_name","id");
          return json_encode($products);
      }
}
