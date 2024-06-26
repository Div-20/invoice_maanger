@extends('admin.layout.admin-layout')
@php
    $page_title = $aRow ? "Edit Currencies" : "Add New Currencies";
    $aAuth = \Auth::guard('admin')->user();
@endphp
@section('title')
    {{ $page_title }}
@endsection
@section('nav-manu-content')
    <li class="nav-item d-none d-sm-inline-block">
        <a href="{{ route('admin.dashboard') }}" class="nav-link">Dashboard</a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
        <a href="{{ route('admin.users.index') }}" class="active nav-link">Back</a>
    </li>
@endsection

@push('add-css')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
@endpush
@push('add-script')
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
    <script>
        $('.summernote').summernote({
            tabsize: 2,
            height: 100
        });
    </script>
@endpush

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>{{ $page_title }}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">{{ $page_title }}</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">


            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="card card-primary card-outline">
                            <!-- Default box -->
                            <div class="card-body">
                                @if ($aRow)
                                    {!! Form::open(['action' => ['App\Http\Controllers\AdminControllers\ManageCurrencyController@update', $aRow->id], 'role' => 'form', 'enctype' => 'multipart/form-data']) !!}
                                    @method('PATCH')
                                @else
                                    {!! Form::open(['action' => 'App\Http\Controllers\AdminControllers\ManageCurrencyController@store', 'role' => 'form', 'enctype' => 'multipart/form-data']) !!}
                                @endif

                                <div class="form-group">
                                    <label>Name</label>
                                    <input type=" text" class="form-control @error('name') is-invalid @enderror " name='name' value="{{ $aRow->name ?? old('name') }}" placeholder="Enter currency or country name">
                                    @error('name')
                                        <label class="control-label text-danger" for="inputError"><i class="fa fa-times-circle text-danger "></i>&nbsp;&nbsp;{{ $message }}</label>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Code</label>
                                    <input type=" text" class="form-control @error('code') is-invalid @enderror " name='code' value="{{ $aRow->code ?? old('code') }}" placeholder="Enter Country code">
                                    @error('code')
                                        <label class="control-label text-danger" for="inputError"><i class="fa fa-times-circle text-danger "></i>&nbsp;&nbsp;{{ $message }}</label>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Symbol</label>
                                    <input type=" text" class="form-control @error('symbol') is-invalid @enderror " name='symbol' value="{{ $aRow->symbol ?? old('symbol') }}" placeholder="Enter Currency symbol">
                                    @error('symbol')
                                        <label class="control-label text-danger" for="inputError"><i class="fa fa-times-circle text-danger "></i>&nbsp;&nbsp;{{ $message }}</label>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Thousand Separator</label>
                                    <input type=" text" class="form-control @error('thousand_separator') is-invalid @enderror " name='thousand_separator' value="{{ $aRow->thousand_separator ?? old('thousand_separator') }}" placeholder="Enter thousand Separator eg. (,)">
                                    @error('thousand_separator')
                                        <label class="control-label text-danger" for="inputError"><i class="fa fa-times-circle text-danger "></i>&nbsp;&nbsp;{{ $message }}</label>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Decimal Separator</label>
                                    <input type=" text" class="form-control @error('decimal_separator') is-invalid @enderror " name='decimal_separator' value="{{ $aRow->decimal_separator ?? old('decimal_separator') }}" placeholder="Enter Decimal Separator eg. (.)">
                                    @error('decimal_separator')
                                        <label class="control-label text-danger" for="inputError"><i class="fa fa-times-circle text-danger "></i>&nbsp;&nbsp;{{ $message }}</label>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Exchange Rate</label>
                                    <input type="number" class="form-control @error('exchange_rate') is-invalid @enderror " name='exchange_rate' value="{{ $aRow->exchange_rate ?? old('exchange_rate') }}" placeholder="Enter Exchange Rate">
                                    @error('exchange_rate')
                                        <label class="control-label text-danger" for="inputError"><i class="fa fa-times-circle text-danger "></i>&nbsp;&nbsp;{{ $message }}</label>
                                    @enderror
                                </div>
                                <div class="box-footer intrfacr">
                                    <button type="reset" class="btn btn-default">Refresh</button>
                                    <button type="submit" class="btn btn-info pull-right">Submit</button>
                                </div>
                                {!! Form::close() !!}
                            </div>
        
                        </div>
                    </div>
                </div>
            </div>


        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection