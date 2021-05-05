<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InvoicesController;
use App\Http\Controllers\SectionsController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\InvoicesDetailsController;
use App\Http\Controllers\InvoiceAchiveController;
use App\Http\Controllers\InvoicesAttachmentsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\reportController;
use App\Http\Controllers\AdminController;


//-----------------------------------------------------------------------------------------------
Route::get('/', function () {
    return view('auth.login');
});
Auth::routes(); // 1

//-----------------------------------------------------------------------------------------------
Route::get('test', function(){
    return 'test';
});
// Auth::routes(['register'=> FALSE]);
//-----------------------------------------------------------------------------------------------


        Route::get('/home', [HomeController::class, 'index'])->name('home'); //2
        //-----------------------------------------------------------------------------------------------
        //قائــمة الفواتيــر
        Route::resource('invoices', InvoicesController::class);
        //الأقســــام
        Route::resource('section', SectionsController::class);
        //المنتـــجات
        Route::resource('products', ProductsController::class);
        //-----------------------------------------------------------------------------------------------
        //تقارير الفواتير
        Route::get('invoices_report',[reportController::class, 'index']);
        Route::get('search_invoices',[reportController::class, 'search_invoices']);
        //تقارير العملاء
        Route::get('customers_report',[reportController::class, 'index2']);
        Route::get('search_customers',[reportController::class, 'search_customers']);
        //-----------------------------------------------------------------------------------------------
        //حذف قسم من الاقسام
        Route::get('/section/{id}',[SectionsController::class, 'index']);
        //القسم في الفاتورة
        Route::get('/InvoicesDetails/{id}',[InvoicesDetailsController::class, 'edit']);
        //-----------------------------------------------------------------------------------------------
        //تحميل المرفق
        Route::get('download/{invoice_number}/{file_name}',[InvoicesDetailsController::class, 'get_file']);
        //فتح المرفق
        Route::get('View_file/{invoice_number}/{file_name}',[InvoicesDetailsController::class, 'open_file']);
        //حذف المرفق
        Route::post('delete_file',[InvoicesDetailsController::class, 'destroy'])->name('delete_file');
        //اضافة مرفق
        Route::post('InvoiceAttachments',[InvoicesAttachmentsController::class, 'store']);
        //-----------------------------------------------------------------------------------------------
        //تعديل الفاتورة
        Route::get('edit_invoice/{id}',[InvoicesController::class, 'edit']);
        //تحديث تعديل الفاتورة
        Route::get('invoices.update',[InvoicesController::class, 'update']);
        //حذف فاتورة
        Route::post('invoices.destroy/{id}',[InvoicesController::class, 'destroy']);
        //تحديث حالة الفاتورة
        Route::get('Status_show/{id}',[InvoicesController::class, 'show'])->name('Status_show');
        //تحديث حالة الدفع
        Route::post('status_update/{id}',[InvoicesController::class, 'Status_Update'])->name('Status_Update');
        //طباعة فاتورة
        Route::get('Print_invoice/{id}',[InvoicesController::class, 'Print_invoice']);
        // تصدير فاتورة اكسيل
        Route::get('export_invoices', [InvoicesController::class, 'export']);
        //-----------------------------------------------------------------------------------------------
        //الفواتير المدفوعة
        Route::get('Invoice_Paid',[InvoicesController::class, 'Invoice_Paid']);
        // الفواتير الغير مدفوعة
        Route::get('Invoice_UnPaid',[InvoicesController::class, 'Invoice_UnPaid']);
        // الفواتير المدفوعة جزئياً
        Route::get('Invoice_Partial',[InvoicesController::class, 'Invoice_Partial']);
        //الفواتير المؤرشفة
        Route::resource('Archive', InvoiceAchiveController::class);
        //-----------------------------------------------------------------------------------------------

//صلاحيات المستخدمين
Route::group(['middleware' => ['auth']], function() {
        Route::resource('roles', RoleController::class);
        Route::resource('users', UserController::class);
});
Route::post('users/{user_id}',[UserController::class, 'destroy'])->name('delete');
//-----------------------------------------------------------------------------------------------
//الاشعاءات
// Route::get('send', [HomeController::class,'sendNotification']);
//الصفحة الرئيســــية
Route::get('/{page}',[AdminController::class, 'index']); //3



