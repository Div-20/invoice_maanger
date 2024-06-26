@extends('admin.layout.admin-layout')
@inject('mediaObj', 'App\Models\Media')
@inject('sliderObj', 'App\Models\Slider')
@php
    $page_title = $aRow ? 'Edit Slider' : 'Add New Slider';
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
        <a href="{{ route('admin.slider.index') }}" class="active nav-link">Back</a>
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

                    <!-- Default box -->
                    <div class="card-body">
                        @if ($aRow)
                            {!! Form::open([ 'action' => ['App\Http\Controllers\AdminControllers\AdminHomeController@slider_update', $aRow->id], 'role' => 'form', 'enctype' => 'multipart/form-data', ]) !!}
                        @else
                            {!! Form::open([ 'action' => 'App\Http\Controllers\AdminControllers\AdminHomeController@slider_update', 'role' => 'form', 'enctype' => 'multipart/form-data', ]) !!}
                        @endif
                        <div class="row mx-0">
                            <div class="col-sm-6 p-0">
                                @php
                                    $customPath = $mediaObj::$directory[$mediaObj::SLIDER];
                                    $single_second = true;
                                @endphp
                                @include('include.uploadimage')
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Type</label>
                            {!! Form::select('type', ['' => '---Select Type---'] + $sliderObj::$type, $aRow->type ?? old('type'), ['class' => (($errors->has('type')) ? 'is-invalid' : '') . " form-control"], ) !!}
                            @error('parent')
                                <label class="col-form-label" for="inputError"><i class="fa fa-times-circle text-danger "></i>&nbsp;&nbsp;{{ $message }}</label>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Image Alt text</label>
                            <input type=" text" class="form-control @error('alt') is-invalid @enderror" name='alt' value="{{ $aRow->alt ?? old('alt') }}" placeholder="Enter alt text">
                            @error('alt')
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
        $("#parent_category").select2({
            ajax: {
                url: "{{ route('ajax.get-parent-category') }}",
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
            placeholder: 'Search paren category',
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
