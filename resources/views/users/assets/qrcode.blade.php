@extends('layouts.app')
@inject('mediaObj', 'App\Models\Media')
@php
    $page_title =  'Print sticker';
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
        <a href="/oc-admin/assets" class="active nav-link">Back</a>
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
            <div class="container" >
                <div class="row" id='printMe'>
                    <div class="col-md-4 col-sm-12 col-xs-12">
                        <div class="card card-primary card-outline">
                            <div class="card-body">
                                <table>
                                    <tr>
                                        <th rowspan="4" class="pr-2 w-0">
                                            <div class="border_right pr-2">
                                            {!! QrCode::generate(url('user/qrcode/'.base64_encode((isset($asset->building->code)?$asset->building->code:'').'/'.(isset($asset->asset_type->code)?$asset->asset_type->code:'').'/'.$asset->unique_id))) !!}
                                            </div>
                                        </th>
                                        <th colspan="2" class="pl-2 border_bottom w-50"><strong>{{(isset($asset->building->code)?$asset->building->code:'').'/'.(isset($asset->asset_type->code)?$asset->asset_type->code:'').'/'.$asset->unique_id }}</strong></th>
                                    </tr>
                                    <tr class="pl-2" >
                                        <th>Building:</th>
                                        <td>{{isset($asset->building_block->building->name)?$asset->building_block->building->name:''}}</td>
                                    </tr>
                                    <tr class="pl-2" >
                                        <th>Type:</th>
                                        <td>{{isset($asset->asset_type->name)?$asset->asset_type->name:'' }}</td>
                                    </tr>
                                    <tr class="pl-2" >
                                        <th>Name:</th>
                                        <td>{{ json_decode($asset->asset_json)->asset_name }}</td>
                                    </tr>
                                </table>
                            </div>
                            <!-- /.card -->
                        </div>
                    </div>
                </div>
                <div class="pull-right">
                    <button type="button" class="btn btn-success w-10" onclick="printDiv('printMe')">Print</button>
                </div>
            </div>
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection

@push('add-script')
    <script>
           function printDiv(divName){
			var printContents = document.getElementById(divName).innerHTML;
			var originalContents = document.body.innerHTML;

			document.body.innerHTML = printContents;

			window.print();

			document.body.innerHTML = originalContents;

		}
    </script>

    <style>
        .border_bottom
        {
            border-bottom: 1px solid #000
        }
        .w-0
        {
            width: 0%
        }

        .border_right
        {
            border-right: 1px solid #000
        }
        </style>
@endpush
