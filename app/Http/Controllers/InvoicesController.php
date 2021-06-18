<?php

namespace App\Http\Controllers;

use App\Models\invoices;
use Illuminate\Http\Request;

use App\Models\sections;
use Illuminate\Support\Facades\DB;

use App\Models\invoices_details;
use Illuminate\Support\Facades\Auth;
use App\Models\invoice_attachments;

use App\Models\products;
use Illuminate\Support\Facades\Storage;

//عشان ابعت فاتورة ع الميل
use Illuminate\Support\Facades\Notification;
use App\Notifications\Addinvoice;
use App\Models\User;

//for export to excel
use App\Exports\InvoicesExport;
 use Maatwebsite\Excel\Facades\Excel;
//  use App\Notifications\Add_invoices;
class InvoicesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // echo 'ddd';
   
      $invoices=invoices::all();
      return view('invoices.invoices',compact('invoices'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        // $invoices=invoices::all();
        $sections=sections::all();
        return view('invoices.add_invoices',compact('sections'));
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
       // return $request;
       //1-insert into invoices table
       invoices::create([
           'invoice_number'=>$request->invoice_number1,
           'invoice_Date'=>$request->invoice_Date,
           'Due_date'=>$request->Due_date,
           'product'=>$request->product,
           'section_id'=>$request->Section,
           'Amount_collection'=>$request->Amount_collection,
           'Amount_Commission'=>$request->Amount_Commission,
           'Discount'=>$request->Discount,
           'Value_VAT'=>$request->Value_VAT,
           'Rate_VAT'=>$request->Rate_VAT,
           'Total'=>$request->Total,
           'Status'=>'غير مدفوعه',
           'Value_Status'=>2,
           'note'=>$request->note,
       ]);
       //2: insert into invoices_details table
       // بقوله بعد مضيف هتروح علي جدول الفواتير واخر فاتوره ضفتها هجبلي الاي دي بتاعها
       //عشان اضفها في جدول تفاصيل الفاتورة
       $invoice_id=invoices::latest()->first()->id;
       invoices_details::create([
          //  'id_Invoice'=>$request->invoice_number1,
           'id_Invoice'=>$invoice_id,
           'invoice_number'=>$request->invoice_number1,
            'product'=>$request->product,
            'Section'=>$request->Section,
            'Status'=>'غير مدفوعه',
            'Value_Status'=>2,
            'note'=>$request->note,
            'user'=>(Auth::user()->name),
       ]);

      //3 insert into invoicesAttachments table and save upload
      //لو فيه مرفقات hasfile
      if($request->hasFile('pic')){
        $invoice_id=invoices::latest()->first()->id;
        $image=$request->file('pic');
        $file_name=$image->getClientOriginalName();
        $invoice_number=$request->invoice_number1;

        $attachments=new invoice_attachments();
        $attachments->invoice_id=$invoice_id;
        $attachments->invoice_number=$invoice_number;
        $attachments->file_name=$file_name;
        $attachments->Created_by=Auth::user()->name;
        $attachments->save();

        //move pic
        $imageName=$request->pic->getClientOriginalName();
        $request->pic->move(public_path('Attachments/'.$invoice_number),$imageName);
        //goto public folder and create Attachments folder and then create folder by invoicenumber
        //after that set pic in the invicenubmer folder
        //انشا مجلد اسمه Attachments
        //وانشا جواه مجلد برقم الفاتورة وضع جواه صوره المختارة

      }
      //ارسال ميل بالفاتورة

      // $user=User::first();
      //  //$user دي فيها حاليا معلومات اليوزر اللي فاتح عندي حاليا
      // Notification::send($user,new Addinvoice($invoice_id));
      
     //ارسال ميل بالفاتورة
    //  $user = User::get();

    //دي هيبعت اشعار لليوزر اللي انشاء الفاتورة بس 
    //  $user = User::find(Auth::user()->id);

     $user = User::get();
     $invoices = invoices::latest()->first();
     Notification::send($user, new \App\Notifications\Add_invoices($invoices));
    //  $user->notify(new \App\Notifications\Add_invoices($invoice_id));

    //  $details = [
    //          'greeting' => 'Hi Artisan',
    //          'body' => 'This is our example notification tutorial',
    //          'thanks' => 'Thank you for visiting codechief.org!',
    //  ];
 

      session()->flash('Addinvoice');
      return redirect("/invoices");

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\invoices  $invoices
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
     // $sections=sections::all();
      $invoices=invoices::where('id',$id)->first();
     // return $invoices;
     return view('invoices.status_update',compact('invoices'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\invoices  $invoices
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        //echo $id;
        $sections=sections::all();
        $invoices=invoices::where('id',$id)->first();
       // return $invoices;
       return view('invoices.edit_invoices',compact('invoices','sections'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\invoices  $invoices
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
       // return $request;
       //1-update into invoices table
       $invoices=invoices::findOrFail($request->invoice_id);
       $invoices->update([
        'invoice_number'=>$request->invoice_number1,
        'invoice_Date'=>$request->invoice_Date,
        'Due_date'=>$request->Due_date,
        'product'=>$request->product,
        'section_id'=>$request->Section,
        'Amount_collection'=>$request->Amount_collection,
        'Amount_Commission'=>$request->Amount_Commission,
        'Discount'=>$request->Discount,
        'Value_VAT'=>$request->Value_VAT,
        'Rate_VAT'=>$request->Rate_VAT,
        'Total'=>$request->Total,
        'Status'=>'غير مدفوعه',
        'Value_Status'=>2,
        'note'=>$request->note,
    ]);

    //  //2: insert into invoices_details table
    //  $details=invoices_details::where('id_Invoice',$request->invoice_id)->first();
    //  $details->update([
    //       //  'id_Invoice'=>$request->invoice_number1,
    //        'id_Invoice'=>$request->invoice_id,
    //        'invoice_number'=>$request->invoice_number1,
    //         'product'=>$request->product,
    //         'Section'=>$request->Section,
    //         'note'=>$request->note,
    //         'user'=>(Auth::user()->name),
    //    ]);

    //الجزء الخاص بارسال اشعار تعديل الفاتورة 
    $user = User::get();
    $invoices = $invoices;
    Notification::send($user, new \App\Notifications\Edit_invoices($invoices));
   //الجزء الخاص بارسال اشعار تعديل الفاتورة 

       session()->flash('Edit','تم تعديل الفاتورة بنجاح ');
       //   return redirect('/products');
         return redirect("/invoices");
   
      
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\invoices  $invoices
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //
     // return  $request;
      $id=$request->invoice_id;
      $invoices=invoices::where('id',$id)->first();
      $details=invoice_attachments::where('invoice_id',$id)->first();
      $id_page=$request->id_page;

      //يعني لو اختار يحذف مش يارشف
      //يعني مجبش id_page معاه
      if(!$id_page==2){
       if(!empty($details->invoice_number)){
        Storage::disk('public_uploads')->deleteDirectory($details->invoice_number);
      }
       //يتم الحذف نهائيا من قاعدة البيانات
       $invoices->forcedelete();
       session()->flash('delete_invoice');
       return redirect('/invoices');
      }

      //يبقي هيعمل ارشفة
    else{
      $invoices->delete();

    //الجزء الخاص بارسال اشعار تعديل الفاتورة 
    $user = User::get();
    $invoices = $invoices;
    Notification::send($user, new \App\Notifications\Archive_invoices($invoices));
   //الجزء الخاص بارسال اشعار تعديل الفاتورة 
   
      session()->flash('Archive_invoice');
      return redirect('/invoices');
    }
     
      // في حالة الحذف نهائي
    //  $details=invoice_attachments::where('invoice_id',$id)->first();
       //كد هيحذفلك صورة صورة داخل ملف 
    //   if(!empty($details->invoice_number)){
     //   Storage::disk('public_uploads')->deleteDirectory($details->invoice_number);
    //  }
      //يتم الحذف نهائيا من قاعدة البيانات
      // $invoices->forcedelete();
      session()->flash('delete_invoice');
      return redirect('/invoices');
     //return redirect()->route('invoices.index');

    }

    public function getproducts($id){
      //  $products=products::where('section_id',$id)->pluck("product_name","id");
        $products=DB::table("products")->where("section_id",$id)->pluck("product_name","id");
        return json_encode($products);
    }

    public function status_update($id,Request $request){
     // return $request;
     $invoices=invoices::findOrFail($id);

      ///start if
     if($request->Status === 'مدفوعة'){
      $invoices->update([
          'Value_Status'=>1,
          'Status'=>$request->Status,
          'Payment_Date'=>$request->Payment_Date
       ]);

       invoices_details::create([
        'id_Invoice'=>$request->invoice_id,
        'invoice_number'=>$request->invoice_number1,
         'product'=>$request->product,
         'Section'=>$request->Section,
         'Value_Status'=>1,
         'Status'=>$request->Status,
         'Payment_Date'=>$request->Payment_Date,
         'user'=>(Auth::user()->name),
       ]);
       
     }
     ///end if
     else{
      $invoices->update([
        'Value_Status'=>3,
        'Status'=>$request->Status,
        'Payment_Date'=>$request->Payment_Date
     ]);

     invoices_details::create([
      'id_Invoice'=>$request->invoice_id,
      'invoice_number'=>$request->invoice_number1,
       'product'=>$request->product,
       'Section'=>$request->Section,
       'Value_Status'=>3,
       'Status'=>$request->Status,
       'Payment_Date'=>$request->Payment_Date,
       'user'=>(Auth::user()->name),
     ]);
     }

     session()->flash('update_invoice');
     return redirect('/invoices');

    }

   //عرض الفواتير المدفوعة
    public function invoices_paid(){
     // return 'hhhh';
     $invoices=invoices::where('Value_Status',1)->get();
     //return $invoices;
     return view('invoices.invoices_paid',compact('invoices'));
    }

    //عرض الفواتير الغير مدفوعة
    public function invoices_unpaid(){
      $invoices=invoices::where('Value_Status',2)->get();
      return view('invoices.invoices_unpaid',compact('invoices'));
     }

     //عرض الفواتير المدفوعة جزئيا
     public function invoices_partailpaid(){
      $invoices=invoices::where('Value_Status',3)->get();
      return view('invoices.invoices_partialpaid',compact('invoices'));
     }

     public function Print_invoice(Request $request){
      
       $invoices=invoices::where('id',$request->id)->first();
      // return $invoices;
      return view('invoices.Print_invoice',compact('invoices'));
     }

     //for export data to excel
     public function export()
    {
      // return 'jjj';
        return Excel::download(new InvoicesExport, 'invoices.xlsx');

        //لو عملت \Excel مش هتحاج اعمل تضمين للمكتبة فوق 
        //مش هحتاج اعمل كده use Maatwebsite\Excel\Facades\Excel;
        return Excel::download(new InvoicesExport, 'invoices.xlsx');

    }

    public function MarkAsRead_all (Request $request)
    {

        $userUnreadNotification= auth()->user()->unreadNotifications;

        if($userUnreadNotification) {
            $userUnreadNotification->markAsRead();
          //عشان افضي جدول الاشعارات
           DB::table("notifications")->delete();
            return back();
        }


    }
}
