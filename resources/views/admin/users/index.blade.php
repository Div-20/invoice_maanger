@extends('admin.layout.admin-layout')
@inject('mediaObj', 'App\Models\Media')
@php
    $page_title = 'Users';
    $add_new_url = route('admin.users.create');
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
            <div class="card">
                @include('admin.layout.__users-search-pill',compact('aQuery'))
            </div>

            <!-- Default box -->
            <div class="card">
                {!! Form::open(['route' => 'updateRequest', 'onsubmit' => 'return confirm("confirm action")']) !!}
                @method('get')
                @include('include.updateRequest')
                <input type="hidden" name="tagName" value="manage_users">
                <div class="card-body p-0" style="display: block;">
                    <table class="projects table table-bordered table-hover table-striped">
                        <thead class="ty-1">
                            <tr>
                            <th style="width:5%"><input type="checkbox" id="selecctall"></th>
                            <th style="width:5%">Role</th>
                            {{-- <th style="width:5%">Prime</th> --}}
                            <th>name</th>
                            <th>Email / Mobile</th>
                            <th style="width:15%">action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($aRows as $key => $item)
                        <tr style=" @if ($item->block == 1) background: #ffa1a1; @endif ">
                            <td><input type="checkbox" class="checkCK_id" name="ck_id[]" value="{{$item->id}}"></td>
                            <td>
                                {{$item->user_role->display_name}}
                                {{-- @if ($item->prime)
                                    @if ($item->prime > \Carbon\Carbon::today())
                                    <span class="badge bg-primary">Prime User</span>
                                    @else
                                    <span class="badge bg-warning">Prime Expired</span>
                                    @endif
                                    <div>{{date('d/m/Y',strtotime($item->prime))}}</div>
                                @endif --}}
                            </td>
                            <td>{{$item->name}}</td>
                            <td>{{ $item->email }} <br> {{ $item->mobile }}</td>
                            <td>
                                {{-- <a onclick="openPopup('{{ route('admin.user.make.prime',$item->id) }}')" href="javascript:void(0)"  class="btn btn-success  btn-sm"><i class="fa fa-eye"></i> Make Prime</a> --}}
                                <a href="{{ route('admin.users.show',$item->id ) }}"  class="btn btn-info  btn-sm"><i class="fa fa-eye"></i> Show</a>
                                <a href="{{ route('admin.users.edit',$item->id) }}" class="btn btn-primary  btn-sm"><i class="fa fa-edit"></i> Edit</a>
                                @if($item->block == 1)
                                    <a href="{{ route( 'admin.user.blockUser',['id'=> $item->id,'status'=>0] )}}" title="UnBlock" class="btn btn-default  btn-sm"><i class="fa fa-ban"></i> UnBlock </a>
                                @else
                                    <a href="{{ route('admin.user.blockUser',['id'=> $item->id,'status'=>1])}}" title="blocked" class="btn btn-warning  btn-sm"><i class="fa fa-ban"></i> Block </a>
                                @endif
                            </td>
                        </tr>
                        @endforeach
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
