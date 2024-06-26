@extends('admin.layout.admin-layout')
@inject('mediaObj', 'App\Models\Media')
@inject('helperObj', 'App\Helpers\CustomHelper')
@php
    $page_title = $aRow ? "Edit User Detail" : "Add New User";
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
                            <div class="card-body row">
                                <div class="form-group col-sm-6">
                                    <div class="form-group">
                                        <label>Full Name</label>
                                        <input type=" text" class="form-control" readonly name='name' value="{{ $aRow->name}}" placeholder="Enter Full Name">
                                    </div>
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="email" class="form-control" readonly name='email' value="{{ $aRow->email}}" placeholder="Enter Email Id">
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <div class="form-group mb-0 py-2 d-flex content-cc">
                                        @if($aRow->image)
                                        <div style="background:url({{$aRow->image}})" class="userProfile userProfile100"></div>
                                        @else
                                        <div style="background:url({{asset('public/img/img_not_found.png')}})" class="userProfile userProfile100"></div>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group col-sm-12">
                                    <label>Mobile No.</label>
                                    <input type="text" class="form-control" readonly name='mobile' value="{{ $aRow->mobile}}" placeholder="Enter Mobile no">
                                </div>
                                <div class="form-group col-sm-12">
                                        <label>State</label>
                                        <input type="text" class="form-control" readonly name='mobile' value="{{ $helperObj::getColumnData('location_states','name','id',$aRow->state) }}" placeholder="country">
                                </div>
                                <div class="form-group col-sm-12">
                                        <label>City</label>
                                        <input type="text" class=" form-control" readonly id="lat" placeholder="city" value="{{ $helperObj::getColumnData('location_cities','name','id',$aRow->city) }}">
                                </div>
                                <div class="form-group col-sm-12">
                                    <label>Address</label>
                                    <textarea class="form-control" rows="3" id="inputError" name="address" readonly  placeholder="Enter Full Address">{{ $aRow->address }}</textarea>
                                </div>
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
