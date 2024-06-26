@extends('admin.layout.admin-layout')
@inject('mediaObj', 'App\Models\Media')
@inject('helperObj', 'App\Helpers\CustomHelper')
@php
    $page_title = $aRow ? "Edit Faq Detail" : "Add New Faq";
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
        <a href="{{ route('admin.faqs.index') }}" class="active nav-link">Back</a>
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
                                @if ($aRow->exists)
                                    {!! Form::open(['action' => ['App\Http\Controllers\AdminControllers\FaqsController@update', $aRow->id], 'role' => 'form', 'enctype' => 'multipart/form-data']) !!}
                                    @method('PATCH')
                                @else
                                    {!! Form::open(['action' => 'App\Http\Controllers\AdminControllers\FaqsController@store', 'role' => 'form', 'enctype' => 'multipart/form-data']) !!}
                                @endif
                                <div class="form-group">
                                    <label>Select Faq Type</label>
                                    {!! Form::select('type', $aRow::$faq_type, $aRow->type ?? old('type'), ['class'=> (($errors->has('type')) ? 'is-invalid' : '') . " form-control",'id'=>'toggle_event']) !!}
                                    @error('type')
                                    <label class="col-form-label" for="inputError"><i class="fa fa-times-circle text-danger "></i>&nbsp;&nbsp;{{ $message }}</label>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Select Faq parent</label>
                                    {!! Form::select('parent_id', ['' => '---Select parent Faq---'] + ($parent_list ?? array()), $aRow->parent_id ?? old('parent_id'), ['class'=> (($errors->has('parent_id')) ? 'is-invalid' : '') . " form-control select2-default"]) !!}
                                    @error('parent_id')
                                    <label class="col-form-label" for="inputError"><i class="fa fa-times-circle text-danger "></i>&nbsp;&nbsp;{{ $message }}</label>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Title</label>
                                    <input type=" text" class="form-control @error('title') is-invalid @enderror" name='title' value="{{ $aRow->title ?? old('title') }}" placeholder="Enter Faq title">
                                    @error('title')
                                        <label class="col-form-label" for="inputError"><i class="fa fa-times-circle text-danger "></i>&nbsp;&nbsp;{{ $message }}</label>
                                    @enderror
                                </div>
                                <div class="form-group toggle_target @if($aRow->exists && $aRow->type == $aRow::FAQ_TYPE_TITLE) d-none @endif">
                                    <label>Descriptions</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" rows="3" id="inputError" name="description" placeholder="Enter Description">{{ $aRow->description ?? old('description') }}</textarea>
                                    @error('description')
                                        <label class="col-form-label" for="inputError"><i class="fa fa-times-circle text-danger "></i>&nbsp;&nbsp;{{ $message }}</label>
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

@push('add-script')
    <script>
        $(document).ready(function() {
            $('#toggle_event').change(function() {
                $('.toggle_target').toggleClass('d-none');
            })
        })
        $('.select2-default').select2()

    </script>
@endpush
