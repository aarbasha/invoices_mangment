<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\invoices;
use App\Models\sections;
use App\Models\invoices_details;
use App\Models\invoices_attachments;
use App\Models\status_update;
use Illuminate\Support\Facades\DB; //add invoices lession 11 from mora soft
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class InvoiceAchiveController extends Controller
{

    public function index() // عرض الفواتير الؤرشفة عند النقر على زر الفواتير المؤرشفة
    {
        $invoices = invoices::onlyTrashed()->get(); // استعلام
        return view('invoices.Archive_Invoices',compact('invoices')); // توجيه
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

  public function update(Request $request) // استعادة الفاتورة المؤرشفة
    {
         $id = $request->invoice_id;
         $flight = Invoices::withTrashed()->where('id', $id)->restore(); // دالة جديدة
         session()->flash('restore_invoice');// اشعار
         return redirect('/invoices'); // توجيه الى
    }

    public function destroy(Request $request) // حذف الفاتورة المؤرشفة نهائياً
    {
         $invoices = invoices::withTrashed()->where('id',$request->invoice_id)->first();
         $invoices->forceDelete(); // دالة جديدة
         session()->flash('delete_invoice');// الشعار
         return redirect('/Archive'); // توجيه الى

    }
}
