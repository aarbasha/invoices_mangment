@extends('layouts.master')
@section('title')
    نظام ادارة الفواتير

@endsection
@section('css')
    <!--  Owl-carousel css-->
    <link href="{{ URL::asset('assets/plugins/owl-carousel/owl.carousel.css') }}" rel="stylesheet" />
    <!-- Maps css -->
    <link href="{{ URL::asset('assets/plugins/jqvmap/jqvmap.min.css') }}" rel="stylesheet">
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
            <div>
                <h2 class="main-content-title tx-24 mg-b-1 mg-b-lg-1 text-info">
                    مرحباً {{ Auth::user()->name }} أهلا بعودتك</h2>
                <p class="mg-b-0">برنامج تحصيل الفواتير</p>
            </div>
        </div>
        <div class="main-dashboard-header-right">
            <div>
                <label class="tx-13">Customer Ratings</label>
                <div class="main-star">
                    <i class="typcn typcn-star active"></i> <i class="typcn typcn-star active"></i> <i
                        class="typcn typcn-star active"></i> <i class="typcn typcn-star active"></i> <i
                        class="typcn typcn-star"></i> <span>(14,873)</span>
                </div>
            </div>
            <div>
                <label class="tx-13">Online Sales</label>
                <h5>563,275</h5>
            </div>
            <div>
                <label class="tx-13">Offline Sales</label>
                <h5>783,675</h5>
            </div>
        </div>
    </div>
    <!-- /breadcrumb -->
@endsection
@section('content')
    <!-- row -->
    <div class="row row-sm">
        <div class="col-xl-4 col-lg-6 col-md-6 col-xm-12">
            <div class="card overflow-hidden sales-card bg-primary-gradient">
                <div class="pl-3 pt-3 pr-3 pb-2 pt-0">
                    <div class="">
                        <h3 class="mb-3  text-white">اجمالي الفواتير </h3>
                    </div>
                    <div class="pb-0 mt-0">
                        <div class="d-flex">
                            <div class="">
                                <h4 class="tx-20 font-weight-bold mb-1 text-white">
                                    {{ \App\Models\invoices::count() }} فواتير
                                </h4>
                                <h4>
                                    $ {{ number_format(\App\Models\invoices::sum('Total'), 2) }}
                                </h4>
                            </div>
                            <span class="float-right my-auto mr-auto">
                                <h4><span class="text-white op-7">100%</span></h4>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-2 col-lg-6 col-md-6 col-xm-12">
            <div class="card overflow-hidden sales-card bg-danger-gradient">
                <div class="pl-3 pt-3 pr-3 pb-2 pt-0">
                    <div class="">
                        <h3 class="mb-3  text-white">الفواتير الغير مدفوعة </h3>
                    </div>
                    <div class="pb-0 mt-0">
                        <div class="d-flex">
                            <div class="">
                                <h4 class="tx-20 font-weight-bold mb-1 text-white">
                                    {{ \App\Models\invoices::where('Status', 'غير مدفوعة')->count() }} فواتير
                                </h4>
                                <h4>
                                    $
                                    {{ number_format(\App\Models\invoices::where('Status', 'غير مدفوعة')->sum('Total'), 2) }}
                                </h4>
                            </div>
                            <span class="float-right my-auto mr-auto">
                                <span class="text-white op-7">
                                    <h4>
                                        {{ round((\App\Models\invoices::where('Status', 'غير مدفوعة')->count() / \App\Models\invoices::count()) * 100) }}%
                                    </h4>
                                </span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-2 col-lg-6 col-md-6 col-xm-12">
            <div class="card overflow-hidden sales-card bg-success-gradient">
                <div class="pl-3 pt-3 pr-3 pb-2 pt-0">
                    <div class="">
                        <h3 class="mb-3  text-white">الفواتير المدفوعة</h3>
                    </div>
                    <div class="pb-0 mt-0">
                        <div class="d-flex">
                            <div class="">
                                <h4 class="tx-20 font-weight-bold mb-1 text-white">
                                    {{ \App\Models\invoices::where('Status', 'مدفوعة')->count() }} فواتير
                                </h4>
                                <h4>
                                    $
                                    {{ number_format(\App\Models\invoices::where('Status', 'مدفوعة')->sum('Total'), 2) }}
                                </h4>
                            </div>
                            <span class="float-right my-auto mr-auto">
                                <span class="text-white op-7">
                                    <h4>
                                        {{ round((\App\Models\invoices::where('Status', 'مدفوعة')->count() / \App\Models\invoices::count()) * 100) }}%
                                    </h4>
                                </span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-2 col-lg-6 col-md-6 col-xm-12">
            <div class="card overflow-hidden sales-card bg-warning-gradient">
                <div class="pl-3 pt-3 pr-3 pb-2 pt-0">
                    <div class="">
                        <h3 class="mb-3 text-white">الفواتير المدفوعة جزئيا</h3>
                    </div>
                    <div class="pb-0 mt-0">
                        <div class="d-flex">
                            <div class="">
                                <h4 class="tx-20 font-weight-bold mb-1 text-white">
                                    {{ \App\Models\invoices::where('Status', 'مدفوعة جزئياً')->count() }} فواتير
                                </h4>
                                <h4>
                                    $
                                    {{ number_format(\App\Models\invoices::where('Status', 'مدفوعة جزئياً')->sum('Total'), 2) }}
                                </h4>
                            </div>
                            <span class="float-right my-auto mr-auto">
                                <span class="text-white op-7">
                                    <h4>
                                        {{ round((\App\Models\invoices::where('Status', 'مدفوعة جزئياً')->count() / \App\Models\invoices::count()) * 100) }}%
                                    </h4>
                                </span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-2 col-lg-6 col-md-6 col-xm-12">
            <div class="card overflow-hidden sales-card bg-secondary-gradient">
                <div class="pl-3 pt-3 pr-3 pb-2 pt-0">
                    <div class="">
                        <h3 class="mb-3  text-white">الفواتير المؤرشفة</h3>
                    </div>
                    <div class="pb-0 mt-0">
                        <div class="d-flex">
                            <div class="">
                            <h4 class="tx-20 font-weight-bold mb-1 text-white">
                                {{ \App\Models\invoices::where('deleted_at')->count() }} فواتير
                            </h4>
                            <h4>
                                $
                                {{ number_format(\App\Models\invoices::where('deleted_at')->sum('Total'), 2) }}
                            </h4>
                        </div>
                        <span class="float-right my-auto mr-auto">
                            <span class="text-white op-7">
                                <h4>
                                    {{ round((\App\Models\invoices::where('deleted_at')->count() / \App\Models\invoices::count()) * 100) }}%
                                </h4>
                            </span>
                        </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- row closed -->

    <!-- row opened -->
    <div class="row row-sm">
        <div class="col-md-12 col-lg-12 col-xl-6">
            <div class="card">
                <div class="card-header bg-transparent pd-b-0 pd-t-20 bd-b-0">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mb-0">Order status</h4>
                        <i class="mdi mdi-dots-horizontal text-gray"></i>
                    </div>
                    <p class="tx-12 text-muted mb-0">Order Status and Tracking. Track your order from ship date to arrival.
                        To begin, enter your order number.</p>
                </div>
                <div class="card-body">
                        {!! $chartjs->render() !!}
                </div>
            </div>
        </div>
        <div class="col-md-12 col-lg-12 col-xl-6">
            <div class="card">
                <div class="card-header bg-transparent pd-b-0 pd-t-20 bd-b-0">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mb-0">Order status</h4>
                        <i class="mdi mdi-dots-horizontal text-gray"></i>
                    </div>
                    <p class="tx-12 text-muted mb-0">Order Status and Tracking. Track your order from ship date to arrival.
                        To begin, enter your order number.</p>
                </div>
                <div class="card-body">
                        {!! $chartjs2->render() !!}
                </div>
            </div>
        </div>
    </div>
    <!-- row closed -->

    <!-- Container closed -->
@endsection
@section('js')
    <!--Internal  Chart.bundle js -->
    <script src="{{ URL::asset('assets/plugins/chart.js/Chart.bundle.min.js') }}"></script>
    <!-- Moment js -->
    <script src="{{ URL::asset('assets/plugins/raphael/raphael.min.js') }}"></script>
    <!--Internal  Flot js-->
    <script src="{{ URL::asset('assets/plugins/jquery.flot/jquery.flot.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/jquery.flot/jquery.flot.pie.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/jquery.flot/jquery.flot.resize.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/jquery.flot/jquery.flot.categories.js') }}"></script>
    <script src="{{ URL::asset('assets/js/dashboard.sampledata.js') }}"></script>
    <script src="{{ URL::asset('assets/js/chart.flot.sampledata.js') }}"></script>
    <!--Internal Apexchart js-->
    <script src="{{ URL::asset('assets/js/apexcharts.js') }}"></script>
    <!-- Internal Map -->
    <script src="{{ URL::asset('assets/plugins/jqvmap/jquery.vmap.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
    <script src="{{ URL::asset('assets/js/modal-popup.js') }}"></script>
    <!--Internal  index js -->
    <script src="{{ URL::asset('assets/js/index.js') }}"></script>
    <script src="{{ URL::asset('assets/js/jquery.vmap.sampledata.js') }}"></script>
@endsection
