@extends('admin.layout.admin-layout')
@inject('mediaObj', 'App\Models\Media')
@php
    $page_title = 'Products';
    $add_new_url = route('admin.product.create');
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
                {!! Form::open(['route' => 'updateRequest', 'onsubmit' => 'return confirm("confirm action")']) !!}
                @method('get')
                @include('include.updateRequest')
                <input type="hidden" name="tagName" value="product-category">
                <div class="card-body p-0" style="display: block;">
                    <table class="projects table table-bordered table-hover table-striped">
                        <thead class="ty-1">
                            <tr>
                                <th style="width:5%"><input type="checkbox" id="selecctall"></th>
                                <th style="width:20%">Name</th>
                                <th style="width:30%">Category</th>
                                <th style="width:30%">Stock</th>
                                <th style="width:10%">Status</th>
                                <th style="width:15%">action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($aRows as $key => $item)
                                <tr>
                                    <td><input type="checkbox" class="checkCK_id" name="ck_id[]"
                                            value="{{ $item->id }}"></td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->category }}</td>
                                    <td>{{ $item->stock }}</td>                                    
                                    <td>{!! $item->status == $item::STATUS_ACTIVE ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-danger ">InActive</span>' !!}</td>
                                    <td>
                                        <a href="{{ route('admin.category.edit', $item->id) }}" class="btn btn-primary  btn-xs"><i class="fa fa-edit"></i></a>
                                    </td>
                                </tr>
                            @empty
                                <tr style="width:100%">
                                    <td >No data added</td>
                                </tr>
                            @endforelse
                            
                        </tbody>
                    </table>
                    {!! Form::close() !!}
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
