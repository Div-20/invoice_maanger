@extends('admin.layout.admin-layout')
@php
    $page_title = 'Asset Detail';
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
        <a href="{{ route('admin.assets.index') }}" class="active nav-link">Back</a>
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
                        <table class="projects table table-bordered table-hover table-striped show_details">
                            {{-- <tr>
                                <td>Asset Unique Code</td>
                                <td>{{ (isset($asset_data->building->code)?$asset_data->building->code:'').'/'.(isset($asset_data->asset_type->code)?$asset_data->asset_type->code:'').'/'.$asset_data->unique_id }}</td>
                            </tr> --}}
                            @php
                                $asset_details = json_decode($asset_data->asset_json,true);
                            @endphp
                            @foreach ($asset_details as $asset_title => $asset_data_val)
                                <tr>
                                    <td>{{ str_replace('_',' ',ucfirst($asset_title)) }}</td>
                                    @if($asset_title!='building')
                                       <td>{{ $asset_data_val ? $asset_data_val : 'N/A' }}</td>
                                    @else
                                       <td>{{isset($asset_data->building_block->building->name)?$asset_data->building_block->building->name:''}}</td>
                                    @endif
                                </tr>
                            @endforeach
                        </table>

                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
