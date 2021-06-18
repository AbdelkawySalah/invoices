<?php

namespace App\Exports;

use App\Models\invoices;
use Maatwebsite\Excel\Concerns\FromCollection;

class InvoicesExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return invoices::all();
         // لو عاوز حقول معينه اللي ترجع نعمل التالي
       // return invoices::select('invoice_number','invoice_Date','product','Total')->get();
    }
}
