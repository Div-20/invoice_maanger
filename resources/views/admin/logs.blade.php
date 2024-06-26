@extends('admin.layout.admin-layout')
@inject('mediaObj', 'App\Models\Media')
@php
    $page_title =  'Site Logs';
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
                <div class="card-body p-0" style="display: block;">
                    <div id="accordion" class="p-2">
                        @forelse ($aRows as $key => $item)
                            <div class="" id="accordion">
                                <div class="card card-outline">
                                    <div class="d-flex card-header">
                                        <div class="d-flex justify-content-between w-100">
                                                <a class="d-block w-50 collapsed" data-toggle="collapse" href="#collapseOne_{{$key}}" aria-expanded="false">
                                                    <h4 class=" card-title mb-0"> 
                                                        {{$item['file_name']}}
                                                    </h4>
                                                </a>
                                                <div class="w-50 text-right">
                                                    {{$item['modify_at']}}
                                                </div>
                                            </div>
                                    </div>
                                    <div id="collapseOne_{{$key}}" class="collapse" data-parent="#accordion" style="">
                                        <div class="card-body">
                                            <code>
                                                {{ (($item['content'])) }}
                                            </code>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                        <div class="text-center h3 ">No Data Found</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
