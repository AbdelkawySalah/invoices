<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\invoices;
class invoiceAchiveController extends Controller
{
    //
    public function index(){
        $invoices=invoices::onlyTrashed()->get();
        return view('invoices.Archive_Invoices',compact('invoices'));
    }

    public function update(){
        return 'sss';
    }
}
