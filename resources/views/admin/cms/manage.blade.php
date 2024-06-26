@extends('admin.layout.admin-layout')
@inject('modalObj', 'App\Models\CMS')
{{-- @inject('helperObj', 'App\Helpers\CustomHelper') --}}
@php
    $page_title = $aRow ? "Edit CMS" : "Add New CMS";
    $aAuth = \Auth::guard('admin')->user();
@endphp
@section('title')
    {{ $page_title }}
@endsection
@section('nav-manu-content')
    <li class="nav-item d-none d-sm-inline-block">
        <a href="{{ route('admin.dashboard') }}" class="nav-link">Dashboard</a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
        <a href="{{ route('admin.users.index') }}" class="active nav-link">Back</a>
    </li>
@endsection

@push('add-css')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
@endpush
@push('add-script')
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
    <script>
        $('.summernote').summernote({
            tabsize: 2,
            height: 100
        });
    </script>
@endpush

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
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">{{ $page_title }}</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">


            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="card card-primary card-outline">
                            <!-- Default box -->
                            <div class="card-body">
                                @if ($aRow)
                                    {!! Form::open(['action' => ['App\Http\Controllers\AdminControllers\CMSController@update', $aRow->id], 'role' => 'form', 'enctype' => 'multipart/form-data']) !!}
                                    @method('PATCH')
                                @else
                                    {!! Form::open(['action' => 'App\Http\Controllers\AdminControllers\CMSController@store', 'role' => 'form', 'enctype' => 'multipart/form-data']) !!}
                                @endif

                                <div class="form-group">
                                    <label>Page Type</label>
                                    @if ($aRow)
                                    <input type="text" disabled class="form-control @error('slug') is-invalid @enderror " value="{{ $aRow->slug ?? old('slug') }}" placeholder="Page Url">
                                    <input type="hidden" name='slug' value="{{ $aRow->slug }}">
                                    @else
                                    {!! Form::select('slug', $modalObj::$slug_type, old('slug'), ['class'=>'form-control']) !!}
                                    @endif
                                    @error('slug')
                                        <label class="control-label text-danger" for="inputError"><i class="fa fa-times-circle text-danger "></i>&nbsp;&nbsp;{{ $message }}</label>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>Title</label>
                                    <input type=" text" class="form-control @error('title') is-invalid @enderror " name='title' value="{{ $aRow->title ?? old('title') }}" placeholder="Enter Full Name">
                                    @error('title')
                                        <label class="control-label text-danger" for="inputError"><i class="fa fa-times-circle text-danger "></i>&nbsp;&nbsp;{{ $message }}</label>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Sub Title</label>
                                    <input type=" text" class="form-control @error('sub_title') is-invalid @enderror " name='sub_title' value="{{ $aRow->sub_title ?? old('sub_title') }}" placeholder="Enter Full Name">
                                    @error('sub_title')
                                        <label class="control-label text-danger" for="inputError"><i class="fa fa-times-circle text-danger "></i>&nbsp;&nbsp;{{ $message }}</label>
                                    @enderror
                                </div>

                                
                                <div class="form-group">
                                    <label>Short Description</label>
                                    <textarea class="form-control @error('short_description') is-invalid @enderror  summernote" rows="3" id="inputError" name="short_description" placeholder="Enter Short Description">{{ $aRow->short_description ?? old('short_description') }}</textarea>
                                    @error('short_description')
                                        <label class="control-label text-danger" for="inputError"><i class="fa fa-times-circle text-danger "></i>&nbsp;&nbsp;{{ $message }}</label>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror  summernote" rows="3" id="summernote" name="description" placeholder="Enter Description">{{ $aRow->description ?? old('description') }}</textarea>
                                    @error('description')
                                        <label class="control-label text-danger" for="inputError"><i class="fa fa-times-circle text-danger "></i>&nbsp;&nbsp;{{ $message }}</label>
                                    @enderror
                                </div>
                                <div class="box-footer intrfacr">
                                    <button type="reset" class="btn btn-default">Refresh</button>
                                    <button type="submit" class="btn btn-info pull-right">Submit</button>
                                </div>
                                {!! Form::close() !!}
                            </div>
        
                        </div>
                    </div>
                </div>
            </div>


        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection