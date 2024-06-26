@extends('admin.layout.admin-layout')
@inject('mediaObj', 'App\Models\Media')
@php
    $page_title = 'News Letter';
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

            <!-- Default box -->
            <div class="card">
                <div class="card-body p-0" style="display: block;">
                    <table class="projects table table-bordered table-hover table-striped">
                        <thead class="ty-1">
                            <tr>
                                <th style="width:20%">Lead SN</th>
                                <th style="width:25%">Total Count Counter</th>
                                <th style="">Email</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($aRows as $key => $item)
                                <tr>
                                    <td>{{ $item->unique_id }}</td>
                                    <td>{{ $item->counter }}</td>
                                    <td>{{ $item->user_email }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="text-center">
                        {!! $aRows->appends(Request::except('page'))->render() !!}
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
