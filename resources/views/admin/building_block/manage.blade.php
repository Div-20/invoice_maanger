@extends('admin.layout.admin-layout')
@php
    $page_title = $aRow ? 'Edit Block' : 'Add New Block';
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
        <a href="{{ route('admin.category.index') }}" class="active nav-link">Back</a>
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
                           {{Form::open(array('url' =>route('admin.building-block.update', $aRow->id), 'files' => true))}}

                            @method('PATCH')
                        @else
                        {{Form::open(array('url' =>route('admin.building-block.store'), 'files' => true))}}

                        @endif
                        <div class="row">
                            <div class="form-group col-lg-6">
                                <label>Select Department</label>
                                <select name="department_id" class="form-control @error('room_no') is-invalid @enderror" id="department_id">
                                    <option>--Please Select--</option>
                                    @foreach ($departments as $item)
                                        <option value="{{$item->id}}" @if(!empty($aRow))@if($item->id == $aRow->department_id) selected @endif @endif>{{$item->name}}</option>
                                    @endforeach

                                </select>

                                @error('department_id')
                                    <label class="col-form-label" for="inputError"><i class="fa fa-times-circle text-danger "></i>&nbsp;&nbsp;{{ $message }}</label>
                                @enderror
                            </div>
                            <div class="form-group col-lg-6">
                                <label>Select Building</label>
                                <select name="building_id" class="form-control @error('room_no') is-invalid @enderror" id="building_id">
                                    <option>--Please Select--</option>
                                    @foreach ($buildings as $item)
                                        <option value="{{$item->id}}" @if(!empty($aRow)) @if($item->id == $aRow->building_id) selected @endif @endif>{{$item->name}}</option>
                                    @endforeach

                                </select>

                                @error('building_id')
                                    <label class="col-form-label" for="inputError"><i class="fa fa-times-circle text-danger "></i>&nbsp;&nbsp;{{ $message }}</label>
                                @enderror
                            </div>
                            <div class="form-group col-lg-6">
                                <label>Select Floor</label>
                                <select name="floor_id" class="form-control @error('room_no') is-invalid @enderror" id="floor_id">
                                    <option>--Please Select--</option>
                                    @foreach ($floors as $item)
                                        <option value="{{$item->id}}" @if(!empty($aRow)) @if($item->id == $aRow->floor_id) selected @endif @endif>{{$item->name}}</option>
                                    @endforeach

                                </select>

                                @error('floor_id')
                                    <label class="col-form-label" for="inputError"><i class="fa fa-times-circle text-danger "></i>&nbsp;&nbsp;{{ $message }}</label>
                                @enderror
                            </div>


                            <div class="form-group col-lg-6">
                                <label>Room No.</label>
                                <input type=" text" class="form-control @error('room_no') is-invalid @enderror" name='room_no' value="{{ $aRow->room_no ?? old('room_no') }}" placeholder="Enter Room No.">
                                @error('room_no')
                                    <label class="col-form-label" for="inputError"><i class="fa fa-times-circle text-danger "></i>&nbsp;&nbsp;{{ $message }}</label>
                                @enderror
                            </div>
                        </div>
                        <div class="box-footer intrfacr">
                            <button type="reset" class="btn btn-danger">Refresh</button>
                            <button type="submit" class="btn btn-success pull-right">Submit</button>
                        </div>
                        {!! Form::close() !!}
                    </div>
                    <!-- /.card -->

                </div>
            </div>


        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection

