@extends('admin.layout.admin-layout')
@php
    $page_title = 'Asset Type';
    $add_new_url = route('admin.asset-type.create');
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
                        <h1>Manage {{ $page_title }}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Manage {{ $page_title }}</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">

            <!-- Default box -->
            <div class="card">
                @method('get')
                <div class="float-left">
                    <a href="{{ $add_new_url }}" class="btn btn-success rounded-0" style="margin:10px;"><i class="fa fa-plus"></i> Add</a>
                </div>
                <div class="card-body p-0" style="display: block;">
                    <table class="projects table table-bordered table-hover table-striped">
                        <thead class="ty-1">
                            <tr>
                                <th style="width:5%">S No.</th>
                                <th style="width:10%">Name</th>
                                <th style="width:10%">Code</th>
                                <th style="width:10%">Asset count</th>
                                <th style="width:15%">action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($aRows as $key => $item)
                                <tr>
                                    <td>{{$key + 1}}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ strtoupper($item->code)}}</td>
                                    <td>{{ $item->assets_count }}</td>
                                    <td>
                                        <div class="btn-group">
                                        <a href="{{ route('admin.asset-type.edit', $item->id) }}" class="btn btn-primary  btn-xs" title="Edit"><i class="fa fa-edit"></i></a>

                                        <form action="{{ route('admin.asset-type.destroy',$item->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-primary btn-danger btn-xs" title="Delete"><i class="fa fa-trash"></i></button>
                                        </form>

                                        </div>
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
