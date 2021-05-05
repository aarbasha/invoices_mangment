<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\InvoicesController;
use App\Models\invoices;
//---------------------------------------------------------------------------
class HomeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    //---------------------------------------------------------------------------
    public function index()
    {

        $count_total = invoices::count(); //الاجمالي
        $inco_1= invoices::where('Status', 'غير مدفوعة')->count(); //غير مدفوعة
        $inco_2= invoices::where('Status', 'مدفوعة')->count(); // مدفوعة
        $inco_3= invoices::where('Status', 'مدفوعة جزئياً')->count(); //مدفوعة جزئياً
        $percentage1 =round($inco_1 / $count_total * 100);
        $percentage2 =round($inco_2 / $count_total * 100);
        $percentage3 =round($inco_3 / $count_total * 100);

        $chartjs = app()->chartjs
        ->name('pieChartTest')
        ->type('pie')
        ->size(['width' => 400, 'height' => 200])
        ->labels(['الاجمالي', 'الغير مدفوعة','مدفوعة', 'مدفوعة جزئيا'])
        ->datasets([
            [
                'backgroundColor' => ['#0475e7','#f84e69','#16a879','#f67436'],
                'hoverBackgroundColor' => ['#0475e7','#f84e69','#16a879','#f67436'],
                'data' => [100,$percentage1, $percentage2,$percentage2]
            ]
        ])
        ->options([]);

        //-----------------------------------------------------barChartTest------------------------
        $chartjs2 = app()->chartjs
        ->name('barChartTest')
        ->type('bar')
        ->size(['width' => 400, 'height' => 200])
        ->labels(['الاجمالي', 'الغير مدفوعة','مدفوعة', 'مدفوعة جزئيا'])
        ->datasets([
            [
                'backgroundColor' => ['#0475e7','#f84e69','#16a879','#f67436'],
                'hoverBackgroundColor' => ['#0475e7','#f84e69','#16a879','#f67436'],
                'data' => [100,$percentage1, $percentage2,$percentage2]
            ]
        ])
        ->options([]);

        return view('pages.home', compact('chartjs','chartjs2'));
    }
}

