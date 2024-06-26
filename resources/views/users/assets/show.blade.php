@extends('layouts.app')
@php
    $page_title = 'Asset Detail';
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
                <div class="card card-primary card-outline">
                    <!-- Default box -->
                    <div class="card-body">
                        <table class="projects table table-bordered table-hover table-striped show_details">
                            <tr>
                                <td>Asset Unique Code</td>
                                <td>{{ $asset_data->unique_id }}</td>
                            </tr>
                            @php
                                $asset_details = json_decode($asset_data->asset_json,true);
                            @endphp
                            @foreach ($asset_details as $asset_title => $asset_data)
                                <tr>
                                    <td>{{ str_replace('_',' ',ucfirst($asset_title)) }}</td>
                                    <td>{{ $asset_data ? $asset_data : 'N/A' }}</td>
                                </tr>
                            @endforeach
                        </table>

                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
