@extends('admin.layout.admin-layout')
@inject('mediaObj', 'App\Models\Media')
@php
    $page_title = 'Manage Slider';
    $add_new_url = route('admin.slider.manage');
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
                <input type="hidden" name="tagName" value="slider">
                <div class="card-body p-0" style="display: block;">
                    <table class="projects table table-bordered table-hover table-striped">
                        <thead class="ty-1">
                            <tr>
                                <th style="width:5%"><input type="checkbox" id="selecctall"></th>
                                <th>Type</th>
                                <th>Image</th>
                                <th>Url</th>
                                <th>Alt</th>
                                <th>Create Date</th>
                                <th>Status</th>
                                <th style="width:10%">Action</th>
                        </thead>
                        <tbody>
                            @foreach ($aRows as $key => $item)
                                <tr>
                                    <td><input type="checkbox" class="checkCK_id" name="ck_id[]" value="{{$item->id}}"></td>
                                    <td>{{ $item::$type[$item->type] }}</td>
                                    <td>{!! HTML::image($item->image , '' , array('class'=>['my-2'], 'height'=>'100','id'=>'productImg')) !!}</td>
                                    <td>
                                        @if ($item->url)
                                            <a href="{{$item->url}}" class="btn btn-info btn-xs" >Link</a>
                                        @endif
                                    </td>
                                    <td>{{ $item->alt}}</td>
                                    <td>{{ $item->created_at->format('d-m-Y') }}</td>
                                    <td>
                                        @if ($item->status == $item::STATUS_ACTIVE)
                                            <label class="label label-success">Active</label>
                                        @else
                                            <label class="label label-danger">Inactive</label>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.slider.manage',$item->id) }}" class="btn btn-primary btn-sm" title="Edit">
                                            <i class="fa fa-edit mr-3"></i>Edit
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {!! Form::close() !!}
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
