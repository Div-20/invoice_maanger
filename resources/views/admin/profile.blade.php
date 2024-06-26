@extends('admin.layout.admin-layout')
@inject('mediaObj', 'App\Models\Media')
@inject('helperObj', 'App\Helpers\CustomHelper')
@php
    $page_title = 'Profile';
    $aAuth = \Auth::guard('admin')->user();
@endphp
@section('title')
    {{ $page_title }}
@endsection
@section('nav-manu-content')
    <li class="nav-item d-none d-sm-inline-block">
        <a href="{{ route('admin.dashboard') }}" class="nav-link">Dashboard</a>
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
                <div class="row">
                    <div class="col-sm-6">
                        <div class="card card-primary card-outline">
                            <!-- Default box -->
                            <div class="card-body">
                                {!! Form::open(['action' => 'App\Http\Controllers\AdminControllers\AdminHomeController@admin_profile', 'role' => 'form', 'enctype' => 'multipart/form-data']) !!}
                                @method('PATCH')
                                <div class="row mx-0">
                                    <div class="col-sm-6 p-0">
                                        @php $customPath = $mediaObj::$directory[$mediaObj::CONSUMER];$single_one = true; @endphp
                                        @include('include.uploadimage')
                                    </div>
                                </div>
        
                                <div class="form-group @error('name') has-error @enderror">
                                    <label>Full Name</label>
                                    <input type=" text" class="form-control" name='name' value="{{ $aRow->name ?? old('name') }}" placeholder="Enter Full Name">
                                    @error('name')
                                        <label class="col-form-label" for="inputError"><i class="fa fa-times-circle text-danger "></i>&nbsp;&nbsp;{{ $message }}</label>
                                    @enderror
                                </div>
                                <div class="form-group @error('email') has-error @enderror">
                                    <label>Email</label>
                                    <input type="email" class="form-control" name='email' value="{{ $aRow->email ?? old('email') }}" placeholder="Enter Email Id">
                                    @error('email')
                                        <label class="col-form-label" for="inputError"><i class="fa fa-times-circle text-danger "></i>&nbsp;&nbsp;{{ $message }}</label>
                                    @enderror
                                </div>
                                <div class="form-group @error('password') has-error @enderror">
                                    <label>password</label>
                                    <input type="password" class="form-control" name='password' value="{{ old('password') }}" placeholder="Enter password">
                                    @error('password')
                                        <label class="col-form-label" for="inputError"><i class="fa fa-times-circle text-danger "></i>&nbsp;&nbsp;{{ $message }}</label>
                                    @enderror
                                </div>
                                <div class="form-group @error('mobile') has-error @enderror">
                                    <label>Mobile No.</label>
                                    <input type="text" class="form-control" name='mobile' value="{{ $aRow->mobile ?? old('mobile') }}" placeholder="Enter mobile">
                                    @error('mobile')
                                        <label class="col-form-label" for="inputError"><i class="fa fa-times-circle text-danger "></i>&nbsp;&nbsp;{{ $message }}</label>
                                    @enderror
                                </div>
                                @php
                                    $grid = 'col-sm-6 px-1';
                                @endphp
                                @include('include.locations')
                                <div class="form-group @error('address') has-error @enderror">
                                    <label>Address</label>
                                    <textarea class="form-control" rows="3" id="inputError" name="address" placeholder="Enter Full Address">{{ $aRow->address ?? old('address') }}</textarea>
                                    @error('address')
                                        <label class="col-form-label" for="inputError"><i class="fa fa-times-circle text-danger "></i>&nbsp;&nbsp;{{ $message }}</label>
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