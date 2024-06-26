@extends('admin.layout.admin-layout')
@inject('mediaObj', 'App\Models\Media')
@php
    $page_title =  ($parent_name ?? 'Site') .' Faq';
    $add_new_url = route('admin.faqs.create-faq',$parent_id);
    $extra_urls = [];
    if ($parent_id == null) {
        // array_push($extra_urls,['url' => route('admin.faqs.final.layout'), 'title' => 'Final faq layout']);
    }
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
                <input type="hidden" name="tagName" value="manage_faqs">
                <div class="card-body p-0" style="display: block;">
                    <div id="accordion" class="px-2">
                        @forelse ($aRows as $key => $item)
                            <div class="" id="accordion">
                                <div class="card card-outline @if ($item->type == $item::FAQ_TYPE_TITLE_DESCRIPTION) card-primary @else card-info @endif">
                                    <div class="d-flex card-header">
                                        <div style="width:2%"><input type="checkbox" value="{{$item->id}}" name="ck_id[]" id="selecctall"></div>
                                        <div style="width:98%" class="d-flex justify-content-between">
                                                <a class="d-block w-100 collapsed" data-toggle="collapse" href="#collapseOne_{{$key}}" aria-expanded="false">
                                                    <h4 class="float-left card-title mb-0"> 
                                                        @if ($item->type == $item::FAQ_TYPE_TITLE_DESCRIPTION)
                                                        <span class="fas fa-angle-down mr-2"></span>
                                                        @else
                                                        <span class="fas fa-plus mr-2"></span>
                                                        @endif
                                                        {{$item->title}}
                                                    </h4>
                                                </a>
                                                <div class="float-right d-flex">
                                                    @if ($item->type == $item::FAQ_TYPE_TITLE)
                                                    <a href="{{ route('admin.faqs.show',$item->id ) }}"  class="btn btn-dark  btn-sm mr-2"><i class="fa fa-angle-right mr-2"></i> View all Child Faqs <span class=" ml-2 badge bg-primary">{{count($item->child)}}</span></a>
                                                    @endif
                                                    <a href="{{ route('admin.faqs.edit',$item->id) }}" class="btn btn-dark  btn-sm mr-2"><i class="fa fa-edit mr-2"></i>Edit</a>
                                                </div>
                                            </div>
                                    </div>
                                    @if ($item->type == $item::FAQ_TYPE_TITLE_DESCRIPTION)
                                    <div id="collapseOne_{{$key}}" class="collapse" data-parent="#accordion" style="">
                                        <div class="card-body">
                                            {{$item->description}}
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>

                        @empty
                        <div class="text-center h3 ">No Data Found</div>
                        @endforelse
                    </div>
                    {!! Form::close() !!}
                    <div class="text-center">
                        {!! $aRows->appends(Request::except('page'))->render() !!}
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
