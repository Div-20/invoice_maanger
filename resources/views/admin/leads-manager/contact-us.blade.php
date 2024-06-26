@extends('admin.layout.admin-layout')
@inject('mediaObj', 'App\Models\Media')
@inject('leadObj', 'App\Models\LeadManagements')
@php
    $page_title = 'Contact Us';
@endphp
@section('title')
    {{ $page_title }}
@endsection
@section('nav-manu-content')
    <li class="nav-item d-none d-sm-inline-block">
        <a href="{{ route('admin.dashboard') }}" class="nav-link">Home</a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Contact</a>
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
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">{{ $page_title }}</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="card">
                @include('admin.layout.__lead-search-pill',compact('aQuery','leadObj'))
            </div>


            <!-- Default box -->
            <div class="card">
                <div class="card-body p-0" style="display: block;">
                    <table class="projects table table-bordered table-hover table-striped">
                        <thead class="ty-1">
                            <tr>
                                <th style="width:5%"><input type="checkbox" id="selecctall"></th>
                                <th style="">Lead SN</th>
                                <th style="">Name</th>
                                <th style="">Email</th>
                                <th style="">Mobile</th>
                                <th style="width:10%">Status</th>
                                <th style="width:15%">action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($aRows as $key => $item)
                                <tr>
                                    <td><input type="checkbox" class="checkCK_id" name="ck_id[]" value="{{ $item->id }}"></td>
                                    <td>{{ $item->unique_id }}</td>
                                    <td>{{ $item->user_name }}</td>
                                    <td>{{ $item->user_email }}</td>
                                    <td>{{ $item->user_mobile }}</td>
                                    <td>{!! '<span class="badge '.$item::$status_bg[$item->status].'">'.$item::$status[$item->status].'</span>' !!}</td>
                                    <td>
                                        <a onclick="openPopup('{{ route('admin.lead.view', $item->unique_id)}}')" href="javascript:void(0)" class="btn btn-primary  btn-xs" title="View"><i class="fa fa-eye"></i> View</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="text-center">
                        {!! $aRows->appends(Request::except('page'))->render() !!}
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
