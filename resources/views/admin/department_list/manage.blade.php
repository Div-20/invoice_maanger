@extends('admin.layout.admin-layout')
@php
    $page_title = $aRow ? 'Edit Department' : 'Add New Department';
    $aAuth = Auth::guard('admin')->user();
@endphp
@section('title')
    {{ $page_title }}
@endsection
@section('nav-manu-content')
    <li class="nav-item d-none d-sm-inline-block">
        <a href="{{ route('admin.dashboard') }}" class="nav-link">Dashboard</a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
        <a href="{{ route('admin.departments.index') }}" class="active nav-link">Back</a>
    </li>
@endsection


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
                <div class="card card-primary card-outline">

                    <!-- Default box -->
                    <div class="card-body">
                        @if ($aRow)

                        {{Form::open(array('url' =>route('admin.departments.update',$aRow->id), 'files' => true))}}
                            {{-- {{Form::open(array('url' =>route('admin.departments.update',$aRow->id), 'files' => true))}} --}}
                            @method('PATCH')
                        @else
                            {{Form::open(array('url' =>route('admin.departments.store'), 'method' => 'post', 'files' => true))}}
                        @endif
                        <div class="form-group">
                            <label>Department Name</label>
                            <input type=" text" class="form-control @error('name') is-invalid @enderror" name='name' value="{{ $aRow->name ?? old('name') }}" placeholder="Enter Full Name">
                            @error('name')
                                <label class="col-form-label" for="inputError"><i class="fa fa-times-circle text-danger "></i>&nbsp;&nbsp;{{ $message }}</label>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Department Code</label>
                            <input type=" text" class="form-control @error('code') is-invalid @enderror" name='code' value="{{ $aRow->code ?? old('code') }}" placeholder="Enter Code">
                            @error('code')
                                <label class="col-form-label" for="inputError"><i class="fa fa-times-circle text-danger "></i>&nbsp;&nbsp;{{ $message }}</label>
                            @enderror
                        </div>
                        <div class="box-footer intrfacr">
                            <button type="reset" class="btn btn-danger">Refresh</button>
                            <button type="submit" class="btn btn-success pull-right">Submit</button>
                        </div>
                        {{-- {!! Form::close() !!} --}}
                    </div>
                    <!-- /.card -->

                </div>
            </div>


        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection

