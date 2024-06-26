@extends('admin.layout.admin-layout')
@inject('mediaObj', 'App\Models\Media')
@php
    $page_title =  'Import Asset';
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
        <a href="{{ route('admin.brands.index') }}" class="active nav-link">Back</a>
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
                <div class="card card-primary card-outline w-50">
                    <form action="{{ route('admin.assets.import') }}" method="POST" enctype="multipart/form-data" id="import_asset">
                        <div class="card-body">
                            @csrf
                            @php
                                $single_doc = true;
                                $fileName = 'asset_file';
                                $labelText = 'Asset File';
                            @endphp
                            @include('include.uploadimage')
                            @if($errors->any())
                                <label class="control-label text-danger" for="inputError"><i class="fa fa-times-circle text-danger "></i>&nbsp;&nbsp; {{ implode('', $errors->all(':message')) }}</label>
                            @endif
                            <div class="box-footer intrfacr row mt-10">

                            </div>

                        </div>
                        <div class="card-footer">
                            <button type="submit" id="submit" class="btn btn-success">Submit</button>
                            <a href="/upload_sheet_format.xlsx" class="btn btn-danger " download>Download Sample</a>
                        </div>

                    </form>
                    <!-- /.card -->

                </div>
            </div>


        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection

@push('add-script')
    <script>

    $(function() {
            $('#import_asset').submit(function() {
                $("button[type='submit']", this)
                    .html("Please Wait...")
                    .attr('disabled', 'disabled');
                    $("#preloader").show();
                return true;
            });
        });
    </script>
@endpush
