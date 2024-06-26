@extends('layouts.app')
@inject('mediaObj', 'App\Models\Media')
@php
    $page_title =  'Import Asset';
    $aAuth = Auth::guard('admin')->user();
@endphp
@section('title')
    {{ $page_title }}
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

                </div>
            </div><!-- /.container-fluid -->

        </section>

        <!-- Main content -->
        <section class="content">


            <div class="container-fluid">
                <div class="card card-primary card-outline w-50">
                    <form action="{{ route('user.assets.import') }}" method="POST" enctype="multipart/form-data" id="import_asset">
                        <div class="card-body">

                            @csrf
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="exampleInputFile" name="asset_file">
                                    <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                </div>

                            </div>
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
