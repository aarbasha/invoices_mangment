<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; // add from Laravel ==> softSoftDeletes ==>remove invoice
use App\models\invoices;
use Illuminate\Support\Facades\Auth;

class invoices extends Model
{
    use HasFactory;
    use SoftDeletes;                 // add from Laravel ==> softSoftDeletes ==>remove invoice
    protected $fillable = [
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
        'Payment_Date',
    ];

    protected $dates = ['deleted_at'];   // add from Laravel ==> softSoftDeletes ==>remove invoice

    public function section()
    {
        return $this->belongsTo(sections::class);
    }

}


