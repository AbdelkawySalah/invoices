<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class invoices extends Model
{
    use HasFactory;
    use SoftDeletes;
    // protected $guarded=[];
    protected $fillable=[
        'invoice_number',
        'invoice_Date',
        'Due_date',
        'product',
        'section_id',
        'Amount_collection',
        'Amount_Commission',
        'Discount',
        'Value_VAT',
        'Rate_VAT',
        'Total',
        'Status',
        'Value_Status',
        'note',
        'Payment_Date'
    ];
    protected $dates=['deleted_at'];

     ///علاقه بين الفاتورة وقسم لاحضار اسم القسم التابع له الفاتورة
     public function sections()
     {
         return $this->belongsTo('App\Models\sections', 'section_id');
     }
}
