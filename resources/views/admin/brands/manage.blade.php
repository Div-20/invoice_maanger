@extends('admin.layout.admin-layout')
@inject('mediaObj', 'App\Models\Media')
@php
    $page_title = $aRow ? 'Edit Brand' : 'Add New Brand';
    $aAuth = Auth::guard('admin')->user();
@endphp
@section('title')
    {{ $page_title }}
@endsection
@section('nav-manu-content')
    <li class="nav-item d-none d-sm-inline-block">
        <a href="{{ route('admin.dashboard') }}" class="nav-link">Dashboard</a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
        <a href="{{ route('admin.brands.index') }}" class="active nav-link">Back</a>
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
                <div class="card card-primary card-outline w-50">
                    <div class="card-body">
                        @if ($aRow)
                            {!! Form::open(['action' => ['App\Http\Controllers\AdminControllers\BrandController@update', $aRow->id], 'role' => 'form', 'enctype' => 'multipart/form-data',]) !!}
                            @method('PATCH')
                        @else
                            {!! Form::open(['action' => 'App\Http\Controllers\AdminControllers\BrandController@store', 'role' => 'form', 'enctype' => 'multipart/form-data',]) !!}
                        @endif
                        <div class="row mx-0">
                            <div class="col-sm-6 p-0">
                                @php $customPath = $mediaObj::$directory[$mediaObj::BRAND]; $single_second = true; @endphp
                                @include('include.uploadimage')
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Parent Brands</label>
                            {!! Form::select( 'parent_id',['' => '---Select parent brands---'] + ($parent_list ?? []), $aRow->parent_id ?? old('parent_id'), ['id' => 'parent_brands', 'class' =>  (($errors->has('parent_id')) ? 'is-invalid' : '') . " form-control"]) !!}
                            @error('parent')
                                <label class="col-form-label" for="inputError"><i class="fa fa-times-circle text-danger "></i>&nbsp;&nbsp;{{ $message }}</label>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Brand Name</label>
                            <input type=" text" class="form-control @error('name') is-invalid @enderror" name='name' value="{{ $aRow->name ?? old('name') }}" placeholder="Enter Brand Name">
                            @error('name')
                                <label class="col-form-label" for="inputError"><i class="fa fa-times-circle text-danger "></i>&nbsp;&nbsp;{{ $message }}</label>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" rows="3" id="inputError" name="description" placeholder="Enter Full description">{{ $aRow->description ?? old('description') }}</textarea>
                            @error('description')
                                <label class="col-form-label" for="inputError"><i class="fa fa-times-circle text-danger "></i>&nbsp;&nbsp;{{ $message }}</label>
                            @enderror
                        </div>
                        <div class="box-footer intrfacr">
                            <button type="reset" class="btn btn-danger">Refresh</button>
                            <button type="submit" class="btn btn-success pull-right">Submit</button>
                        </div>
                        {!! Form::close() !!}
                    </div>
                    <!-- /.card -->

                </div>
            </div>


        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection

@push('add-script')
    <script>
        $("#parent_brands").select2({
            ajax: {
                url: "{{ route('ajax.get-parent-brands') }}",
                method: 'post',
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        search: params.term, // search term
                    };
                },
                processResults: function(data, params) {
                    return {
                        results: data.items,
                    };
                },
                cache: true
            },
            placeholder: 'Search parent brands',
            minimumInputLength: 3,
            templateResult: formatRepo,
            templateSelection: formatRepoSelection
        });

        function formatRepo(aData) {

            if (aData.loading) {
                return aData.text;
            }
            console.log('formatRepo', aData);

            var $container = $(
                "<div class='select2-result-repository clearfix'>" +
                "<div class='border select2-result-repository__meta'>" +
                "<h4 class='my-1 font-weidth-bold'>" + aData.name + "</h4>" +
                "<p class='select2-result-repository__description'>" + aData.description || '' + "</p>" +
                "</div>" +
                "</div>"
            );
            return $container;
        }

        function formatRepoSelection(aData) {
            return aData.name || aData.text;
        }
    </script>
@endpush
