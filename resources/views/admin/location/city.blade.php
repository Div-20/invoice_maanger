@extends('admin.layout.admin-layout')
@inject('mediaObj', 'App\Models\Media')
@php
    $page_title = "$state_detail->name cityes";
    $add_ajax_url = route('admin.location.create',['type'=>'city','id'=>$state_detail->id]);
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
                            <li class="breadcrumb-item"><a href="{{route('admin.locations',['type' => 'state'])}}">{{ $state_detail->name }}</a></li>
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
                @php $activateRegion = true; @endphp
                @include('include.updateRequest')
                <input type="hidden" name="tagName" value="manage_cities">
                <div class="card-body p-0" style="display: block;">
                    <table class="table table-bordered table-hover table-striped" id="data-table">
                        <thead class="ty-1">
                            <tr>
                                <th style="width:5%"><input type="checkbox" id="selecctall"></th>
                                <th>State Name</th>
                                <th>Active Region</th>
                                <th>District Name</th>
                                <th>Name</th>
                                <th class="w-10">icon</th>
                                <th>SUB city</th>
                                <th class="w-10">Tier Type</th>
                                <th>Pin Code</th>
                                <th>Status</th>
                                <th style="width:10%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($aRows as $key => $item)
                            @php
                            $imgArray = explode(',',$item->image);
                            @endphp
                            <tr>
                                <td><input type="checkbox" class="checkCK_id" name="ck_id[]" value="{{$item->id}}"></td>
                                <td>{{ $item->state->name }}</td>
                                <td>
                                    @if ($item->region_status == 1)
                                        <span class="label label-primary">Active</span>
                                    @endif
                                </td>
                                <td>{{ ($item->district) ? $item->district->name : ''}}</td>
                                <td>{{$item->name}}</td>
                                <td>
                                    @if ($item->icon)
                                        <img src="{{asset('uploads/locations/'.$item->icon)}}" alt="" class="img-thumbnail img-responsive img-rounded" srcset=""></td>
                                    @endif
                                <td>{{ ($item->subCites && count($item->subCites)) ? $item->subCites->count() : ''}}</td>
                                <td class="text-center">
                                    @if ($item->tier_type)
                                        <img src="{{asset('images/'.$item::$city_tier_image[$item->tier_type])}}" alt="" class="w-25 img-thumbnail img-responsive img-rounded" srcset=""><br>
                                        <label for="">{{$item::$city_tier_type[$item->tier_type]}}</label>
                                    @else
                                        Not Set
                                    @endif
                                </td>
                                <td>{{$item->pin_code}}</td>
                                <td>
                                    @if ($item->status)
                                        <span class="label label-primary">Active</span>
                                    @else
                                        <span class="label label-danger">InActive</span>
                                    @endif
                                </td>
                                <td>
                                    <a onclick="openPopup('{{ route('show.location',['type'=>'city','id'=>$item->id])}}')" href="javascript:void(0)" class="btn btn-primary  btn-xs" title="Edit">
                                        <i class="fa fa-edit">&nbsp;Update</i>
                                    </a>
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
