<?php

namespace App\Http\Controllers;

use App\Models\User; //Notification InvoicesExport
use App\Models\invoices;
use App\Models\sections;
use App\Models\invoices_details;
use App\Models\invoices_attachments;
use App\Models\status_update;
use App\Notifications\InvoicePaid; //Notification from project
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; //add invoices lession 11 from mora soft
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Notification; // Notification from web laravel
use App\Exports\InvoicesExport;
use Maatwebsite\Excel\Facades\Excel;
//-------------------------------------------------------------------------------------------
class InvoicesController extends Controller
{
    public function index() //عرض صفحة الفواتير
    {
        $invoices = invoices::all();
        return view('invoices.invoices' , compact('invoices'));
    }
    //-------------------------------------------------------------------------------------------
    public function create()
    {
        $sections = sections::all();
        return view('invoices/add_invoice', compact('sections'));

    }
    //-------------------------------------------------------------------------------------------
    public function store(Request $request) // lesson 12  اضافة فاتورة
    {
        invoices::create([
            'invoice_number' => $request->invoice_number,
            'invoice_Date' => $request->invoice_Date,
            'Due_date' => $request->Due_date,
            'product' => $request->product,
            'section_id' => $request->Section,
            'Amount_collection' => $request->Amount_collection,
            'Amount_Commission' => $request->Amount_Commission,
            'Discount' => $request->Discount,
            'Value_VAT' => $request->Value_VAT,
            'Rate_VAT' => $request->Rate_VAT,
            'Total' => $request->Total,
            'Status' => 'غير مدفوعة',
            'Value_Status' => 2,
            'note' => $request->note,
        ]);

        $invoice_id = invoices::latest()->first()->id;
        invoices_details::create([
            'id_Invoice' => $invoice_id,
            'invoice_number' => $request->invoice_number,
            'product' => $request->product,
            'Section' => $request->Section,
            'Status' => 'غير مدفوعة',
            'Value_Status' => 2,
            'note' => $request->note,
            'user' => (Auth::user()->name),
        ]);

        if ($request->hasFile('pic')) {

                $invoice_id = Invoices::latest()->first()->id;
                $image = $request->file('pic');
                $file_name = $image->getClientOriginalName();
                $invoice_number = $request->invoice_number;

                $attachments = new invoices_attachments();
                $attachments->file_name = $file_name;
                $attachments->invoice_number = $invoice_number;
                $attachments->Created_by = Auth::user()->name;
                $attachments->invoice_id = $invoice_id;
                $attachments->save();

                // move pic
                $imageName = $request->pic->getClientOriginalName();
                $request->pic->move(public_path('Attachments/' . $invoice_number), $imageName);
        }

                // $users = user::first(); //send to email user

                // Notification::send($users, new InvoicePaid($invoice_id)); // send to email user

                // $users->notify(new InvoicePaid($invoice_id));

                $user = User::get();
                $invoices = invoices::latest()->first();
                Notification::send($user, new \App\Notifications\InvoicePaid($invoice_id));

                // event(new MyEventClass('hello world'));

                session()->flash('Add', 'تم اضافة الفاتورة بنجاح');
                // return back();
                return redirect('/invoices');

    }
    //-------------------------------------------------------------------------------------------
    public function show($id)
    {
        $invoices = invoices::where('id', $id)->first();
        return view('invoices.status_update' , compact('invoices'));
    }
    //-------------------------------------------------------------------------------------------
    public function edit($id)
    {
        $invoices = invoices::where('id', $id)->first();
        $sections = sections::all();
        return view('invoices.edit_invoice', compact('sections', 'invoices'));
    }
    //-------------------------------------------------------------------------------------------
    public function update(Request $request)
    {
        $invoices = invoices::findOrFail($request->invoice_id);
        $invoices->update([
            'invoice_number' => $request->invoice_number,
            'invoice_Date' => $request->invoice_Date,
            'Due_date' => $request->Due_date,
            'product' => $request->product,
            'section_id' => $request->Section,
            'Amount_collection' => $request->Amount_collection,
            'Amount_Commission' => $request->Amount_Commission,
            'Discount' => $request->Discount,
            'Value_VAT' => $request->Value_VAT,
            'Rate_VAT' => $request->Rate_VAT,
            'Total' => $request->Total,
            'note' => $request->note,
        ]);

        session()->flash('edit', 'تم تعديل الفاتورة بنجاح'); // ADD CODE IN invoices.BLADE.PHP
        // return back();
        return redirect('/invoices');// تعديلاتي

    }
    //-------------------------------------------------------------------------------------------
    public function destroy(Request $request)     // حذف فاتورة
    {
        $id = $request->invoice_id;
        $invoices = invoices::where('id', $id)->first();
        $Details = invoices_attachments::where('invoice_id', $id)->first();

        $id_page =$request->id_page;

        if (!empty($Details->invoice_number)) {

            Storage::disk('public_uploads')->deleteDirectory($Details->invoice_number); // حذف مجلد المرفقات
        }

        if (!$id_page==2) {

            if (!empty($Details->invoice_number)) {

                Storage::disk('public_uploads')->deleteDirectory($Details->invoice_number);
            }
            $invoices->forceDelete();  // حذف نهائياً
            session()->flash('delete_invoice');
            return redirect('/invoices');
            }
            else {
                $invoices->delete();        // نقل الى الارشيف
                session()->flash('archive_invoice');
                // return redirect('/Archive');
                return redirect('/invoices');
            }
    }
    //-------------------------------------------------------------------------------------------
    public function getproducts($id) // اضافة فاتورة
    {
        $products = DB::table("products")->where("section_id", $id)->pluck("Product_name", "id");
        return json_encode($products);
    }
    //-------------------------------------------------------------------------------------------
    public function Status_Update($id, Request $request){ // تحديث حالة الدفع

        $invoices = invoices::findOrFail($id);

        if ($request->Status === 'مدفوعة') {

            $invoices->update([
                'Value_Status' => 1, // مدفوعة
                'Status' => $request->Status,
                'Payment_Date' => $request->Payment_Date,
            ]);

            invoices_Details::create([
                'id_Invoice' => $request->invoice_id,
                'invoice_number' => $request->invoice_number,
                'product' => $request->product,
                'Section' => $request->Section,
                'Status' => $request->Status,
                'Value_Status' => 1,
                'note' => $request->note,
                'Payment_Date' => $request->Payment_Date,
                'user' => (Auth::user()->name),
            ]);

        }

        else {
            $invoices->update([
                'Value_Status' => 3, // مدفوعة جزئياً
                'Status' => $request->Status,
                'Payment_Date' => $request->Payment_Date,
            ]);
            invoices_Details::create([
                'id_Invoice' => $request->invoice_id,
                'invoice_number' => $request->invoice_number,
                'product' => $request->product,
                'Section' => $request->Section,
                'Status' => $request->Status,
                'Value_Status' => 3,
                'note' => $request->note,
                'Payment_Date' => $request->Payment_Date,
                'user' => (Auth::user()->name),
            ]);
        }


        session()->flash('Status_Update'); // اشعار الدفع
        return redirect('/invoices');

    }
    //-------------------------------------------------------------------------------------------
    public function Invoice_Paid(){  //الفواتير المدفوعة

        $invoices = Invoices::where('Value_Status', 1)->get();
        return view('invoices.invoice_paid',compact('invoices'));
    }
    public function Invoice_UnPaid(){ // الفواتير الغير مدفوعة

        $invoices = Invoices::where('Value_Status',2)->get();
        return view('invoices.invoice_unpaid',compact('invoices'));
    }
    public function Invoice_Partial(){ // الفواتير المدفوعة جزئياً

        $invoices = Invoices::where('Value_Status',3)->get();
        return view('invoices.invoice_Partial',compact('invoices'));
    }
    public function Print_invoice($id){ //طباعة فاتورة

        $invoices = invoices::where('id',$id)->first();
        return view('invoices.Print_invoice', compact('invoices'));

    }

    public function export()
    {

        return Excel::download(new InvoicesExport, 'invoices.xlsx');

    }
}

