@extends('admin.layout.admin-layout')
@inject('mediaObj', 'App\Models\Media')
@php
    $page_title = 'State';
    $add_ajax_url = route('admin.location.create', 'state');
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
                <input type="hidden" name="tagName" value="manage_states">
                <div class="card-body p-0" style="display: block;">
                    <table class="table table-bordered table-hover table-striped" id="data-table">
                        <thead class="ty-1">
                            <tr>
                                <th style="width:10%"><input type="checkbox" id="selecctall"></th>
                                <th>Name</th>
                                <th>total City Registered</th>
                                <th>Status</th>
                                <th>View Cities</th>
                                <th style="width:20%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($aRows as $key => $item)
                        @php
                        $imgArray = explode(',',$item->image);
                        @endphp
                            <tr>
                                <td><input type="checkbox" class="checkCK_id" name="ck_id[]" value="{{$item->id}}"></td>
                                <td>{{$item->name}}</td>
                                <td>
                                    {{ $item->cities->count()}}
                                </td>
                                <td>
                                    @if($item->status == 1)
                                        <label class="label label-primary">Active</label>
                                    @else
                                        <label class="label label-danger">Inactive</label>
                                    @endif
                                </td>
                                <td><a href="{{ route('get-cities',$item->id)}}" class="btn btn-warning  btn-xs" title="View Cities data"><i class="fa fa-eye">&nbsp;&nbsp;View All Cities</i></a></td>
                                <td>
                                    <a onclick="openPopup('{{ route('show.location',['type'=>'state','id'=>$item->id])}}')" href="javascript:void(0)" class="btn btn-primary  btn-xs" title="Edit"><i class="fa fa-edit">&nbsp;&nbsp;Update</i></a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {!! Form::close() !!}
                </div>
            </div>
        </section>
    </div>
@endsection
