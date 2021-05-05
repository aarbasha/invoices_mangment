@extends('layouts.master')
@section('css')
    <!--Internal  Font Awesome -->
    <link href="{{ URL::asset('assets/plugins/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <!--Internal  treeview -->
    <link href="{{ URL::asset('assets/plugins/treeview/treeview-rtl.css') }}" rel="stylesheet" type="text/css" />
@section('title')
    اضافة الصلاحيات
@stop

@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">الصلاحيات</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ اضافة
                نوع مستخدم</span>
        </div>
    </div>
</div>
<!-- breadcrumb -->
@endsection

@section('content')

@if (count($errors) > 0)
    <div class="alert alert-danger">
        <button aria-label="Close" class="close" data-dismiss="alert" type="button">
            <span aria-hidden="true">&times;</span>
        </button>
        <strong>خطا</strong>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif




{!! Form::open(['route' => 'roles.store', 'method' => 'POST']) !!}
<!-- row -->
<div class="row">
    <div class="col-md-12">
        <div class="card mg-b-20">
            <div class="card-body">
                <div class="col-lg-12 margin-tb">
                    <div class="pull-right">
                        <a class="btn btn-info btn-xl" href="{{ route('users.index') }}">رجوع الى الخلف</a>
                    </div>
                </div>
                <br>
                <div class="main-content-label mg-b-5">
                    <div class="col-xs-7 col-sm-7 col-md-12">
                        <div class="form-group">
                            <p>اسم الصلاحية :</p>
                            {!! Form::text('name', null, ['class' => 'form-control']) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <!-- col -->
                    <div class="col-lg-12">
                        <ul id="treeview1">
                            <li>
                             <a href="#" class="h3 text-danger">الصلاحيات</a><hr>
                                <ul>
                            </li>
                            @foreach ($permission as $value)
                                <label
                                    style="font-size: 20px;"> <div class="align-content-start flex-wrap text-dark">
                                    {{ Form::checkbox('permission[]', $value->id, false, ['class' => 'name']) }}
                                    {{ $value->name }}</div>
                                </label>

                            @endforeach
                            </li>

                        </ul>
                        </li>
                        </ul>
                        <br>
                    </div>
                    <!-- /col -->
                    <div class="col-xs-3 col-sm-3 col-md-3 text-center">
                        <button type="submit" class="btn btn-main-primary btn-block ">تاكيد</button>
                    </div>

                </div>
            </div>
        </div>

        {!! Form::close() !!}
    @endsection
    @section('js')
        <!-- Internal Treeview js -->
        <script src="{{ URL::asset('assets/plugins/treeview/treeview.js') }}"></script>
    @endsection
