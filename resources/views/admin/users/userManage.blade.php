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
                            <div class="card-body">
                                @if ($aRow)
                                    {!! Form::open(['action' => ['App\Http\Controllers\AdminControllers\UserController@update', $aRow->id], 'role' => 'form', 'enctype' => 'multipart/form-data']) !!}
                                    @method('PATCH')
                                @else
                                    {!! Form::open(['action' => 'App\Http\Controllers\AdminControllers\UserController@store', 'role' => 'form', 'enctype' => 'multipart/form-data']) !!}
                                @endif
                                <div class="row mx-0">
                                    <div class="col-sm-6 p-0">
                                        @php $customPath = $mediaObj::$directory[$mediaObj::CONSUMER];$single_one = true; @endphp
                                        @include('include.uploadimage')
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Full Name</label>
                                    <input type=" text" class="form-control @error('name') is-invalid @enderror" name='name' value="{{ $aRow->name ?? old('name') }}" placeholder="Enter Full Name">
                                    @error('name')
                                        <label class="col-form-label" for="inputError"><i class="fa fa-times-circle text-danger "></i>&nbsp;&nbsp;{{ $message }}</label>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" name='email' value="{{ $aRow->email ?? old('email') }}" placeholder="Enter Email Id">
                                    @error('email')
                                        <label class="col-form-label" for="inputError"><i class="fa fa-times-circle text-danger "></i>&nbsp;&nbsp;{{ $message }}</label>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Mobile No.</label>
                                    <input type="text" class="form-control @error('mobile') is-invalid @enderror" name='mobile' value="{{ $aRow->mobile ?? old('mobile') }}" placeholder="Enter mobile">
                                    @error('mobile')
                                        <label class="col-form-label" for="inputError"><i class="fa fa-times-circle text-danger "></i>&nbsp;&nbsp;{{ $message }}</label>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>password</label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" name='password' value="{{ old('password') }}" placeholder="Enter password">
                                    @error('password')
                                        <label class="col-form-label" for="inputError"><i class="fa fa-times-circle text-danger "></i>&nbsp;&nbsp;{{ $message }}</label>
                                    @enderror
                                </div>


                                <div class="form-group">
                                    <label>Role</label>
                                    {!! Form::select('role', ['' => '---Select Role Type---'] + ($roles ?? []), $aRow->role ?? old('role'), [ 'id' => 'role', 'class' => (($errors->has('area')) ? 'is-invalid' : '') . " form-control select2-tags", ]) !!}
                                    @error('role')
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

@push('add-script')
    <script>
        $(document).ready(function() {
            $('#locationBtn').click(function() {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(showPosition);
                } else {
                    alert("Geolocation is not supported by this browser.")
                }
            })
        })

        function showPosition(position) {
            document.getElementById('lat').value = position.coords.latitude;
            document.getElementById('long').value = position.coords.longitude;
            document.getElementById('btnText').innerHTML = 'Done';
        }

    </script>
@endpush
