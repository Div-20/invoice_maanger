@extends('admin.layout.admin-layout')
@inject('helperObj', 'App\Helpers\CustomHelper')
@php
    $page_title = 'Assets';
    $add_new_url = route('admin.assets.create');
    $aAuth = Auth::guard('admin')->user();
@endphp
@section('title')
    {{ $page_title }}
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
            {{ Form::open(['url' => url('/oc-admin/assets'), 'method' => 'GET', 'id' => 'btfform']) }}
            <div class="row">
                <div class="col-lg-3 col-sm-12 col-xs-12">
                    <div class="form-group row">
                        <div class="col-lg-12">
                            <div class="input-group">
                                <span class="input-group-prepend">
                                    <span class="input-group-text">Search</span>
                                </span>
                                <input type="text" name="search" placeholder="Type to search" class="form-control"
                                    value="{{ app('request')->input('search') }}">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="">
                    <div class="btn-group">
                        <button type="button" id="search" title="Search" onclick="showLoader()"
                            class="btn btn-lg btn-default">
                            <i class="fa fa-search"></i>
                        </button>
                        <a href="javascript:void();" title="Refresh" id="btn_refresh" class="btn btn-default">
                            <i class="fa fa-recycle"></i>
                        </a>
                        <div class="input-group-prepend">
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"
                                aria-expanded="false">
                                <i class="fa fa-download"></i>
                            </button>
                            <div class="dropdown-menu" style="">
                                {{ Form::hidden('short_report', 0) }}
                                {{ Form::hidden('custom_report', 0) }}
                                <a href="javascript:;" data-report="short_report" class="dropdown-item report"><i
                                        class="icon-file-excel"></i> Short Report</a>
                                <a href="javascript:void(0);" class="dropdown-item" data-toggle="modal"
                                    data-target="#custom_report"> <i class="icon-file-excel"></i> Custom Report</a>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
            <div class="modal fade" id="custom_report" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-primary">
                            <h4 class="modal-title" id="largeModalLabel"> Custom Report</h4>
                            <button type="button" class="close" data-dismiss="modal">×</button>
                        </div>
                        <div class="modal-body">
                            <div class="">
                                <div class="custom-control custom-checkbox mb-3 text-center">
                                    <input type="checkbox" name="select_all" id="select_all" class="form-check-input">
                                    <label for="select_all" class="form-check-label" for="cc_ls_u">
                                        Select All
                                    </label>
                                </div>
                                <hr />
                                <div class="row">
                                    <div class="col-md-6 col-sm-12">
                                        <div class="custom-control custom-checkbox mb-3">
                                            <input type="checkbox" name="excel_fields[]" id="building"
                                                value="building" class="form-check-input checkBoxClass">
                                            <label class="form-check-label" for="building">
                                                Building
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="custom-control custom-checkbox mb-3">
                                            <input type="checkbox" name="excel_fields[]" id="building_code"
                                                value="building_code" class="form-check-input checkBoxClass">
                                            <label class="form-check-label" for="building_code">
                                                Building Code
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="custom-control custom-checkbox mb-3">
                                            <input type="checkbox" name="excel_fields[]" id="floor"
                                                value="floor" class="form-check-input checkBoxClass">
                                            <label class="form-check-label" for="floor">
                                                Floor
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="custom-control custom-checkbox mb-3">
                                            <input type="checkbox" name="excel_fields[]" id="room_no"
                                                value="room_no" class="form-check-input checkBoxClass">
                                            <label class="form-check-label" for="room_no">
                                                Room No
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="custom-control custom-checkbox mb-3">
                                            <input type="checkbox" name="excel_fields[]" id="asset_group"
                                                value="asset_group" class="form-check-input checkBoxClass">
                                            <label class="form-check-label" for="asset_group">
                                                Asset Group
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="custom-control custom-checkbox mb-3">
                                            <input type="checkbox" name="excel_fields[]" id="asset_type"
                                                value="asset_type" class="form-check-input checkBoxClass">
                                            <label class="form-check-label" for="asset_type">
                                                Asset Type
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="custom-control custom-checkbox mb-3">
                                            <input type="checkbox" name="excel_fields[]" id="asset_type_code"
                                                value="asset_type_code" class="form-check-input checkBoxClass">
                                            <label class="form-check-label" for="asset_type_code">
                                                Asset Type Code
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="custom-control custom-checkbox mb-3">
                                            <input type="checkbox" name="excel_fields[]" id="asset_name"
                                                value="asset_name" class="form-check-input checkBoxClass">
                                            <label class="form-check-label" for="asset_name">
                                                Asset Name
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="custom-control custom-checkbox mb-3">
                                            <input type="checkbox" name="excel_fields[]" id="detail"
                                                value="detail" class="form-check-input checkBoxClass">
                                            <label class="form-check-label" for="detail">
                                                Detail
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="custom-control custom-checkbox mb-3">
                                            <input type="checkbox" name="excel_fields[]" id="made_of"
                                                value="made_of" class="form-check-input checkBoxClass">
                                            <label class="form-check-label" for="made_of">
                                                Made Of
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="custom-control custom-checkbox mb-3">
                                            <input type="checkbox" name="excel_fields[]" id="make"
                                                value="make" class="form-check-input checkBoxClass">
                                            <label class="form-check-label" for="make">
                                                Make
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="custom-control custom-checkbox mb-3">
                                            <input type="checkbox" name="excel_fields[]" id="model"
                                                value="model" class="form-check-input checkBoxClass">
                                            <label class="form-check-label" for="model">
                                                Model
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="custom-control custom-checkbox mb-3">
                                            <input type="checkbox" name="excel_fields[]" id="capacity"
                                                value="capacity" class="form-check-input checkBoxClass">
                                            <label class="form-check-label" for="capacity">
                                                Capacity
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="custom-control custom-checkbox mb-3">
                                            <input type="checkbox" name="excel_fields[]" id="year_of_mfg"
                                                value="year_of_mfg" class="form-check-input checkBoxClass">
                                            <label class="form-check-label" for="year_of_mfg">
                                                Year of mfg
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="custom-control custom-checkbox mb-3">
                                            <input type="checkbox" name="excel_fields[]" id="year_of_purchase"
                                                value="year_of_purchase" class="form-check-input checkBoxClass">
                                            <label class="form-check-label" for="year_of_purchase">
                                                Year of purchase
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="custom-control custom-checkbox mb-3">
                                            <input type="checkbox" name="excel_fields[]" id="working_condition"
                                                value="working_condition" class="form-check-input checkBoxClass">
                                            <label class="form-check-label" for="working_condition">
                                                Working condition
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="custom-control custom-checkbox mb-3">
                                            <input type="checkbox" name="excel_fields[]" id="remarks"
                                                value="remarks" class="form-check-input checkBoxClass">
                                            <label class="form-check-label" for="remarks">
                                                Remarks
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="custom-control custom-checkbox mb-3">
                                            <input type="checkbox" name="excel_fields[]" id="asset_sno"
                                                value="asset_sno" class="form-check-input checkBoxClass">
                                            <label class="form-check-label" for="asset_sno">
                                                Asset sno
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="custom-control custom-checkbox mb-3">
                                            <input type="checkbox" name="excel_fields[]" id="name"
                                                value="name" class="form-check-input checkBoxClass">
                                            <label class="form-check-label" for="name">
                                                Name
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="custom-control custom-checkbox mb-3">
                                            <input type="checkbox" name="excel_fields[]" id="ref_no"
                                                value="ref_no" class="form-check-input checkBoxClass">
                                            <label class="form-check-label" for="ref_no">
                                                Ref no
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="custom-control custom-checkbox mb-3">
                                            <input type="checkbox" name="excel_fields[]" id="allocated_to"
                                                value="allocated_to" class="form-check-input checkBoxClass">
                                            <label class="form-check-label" for="allocated_to">
                                                Allocated to
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="custom-control custom-checkbox mb-3">
                                            <input type="checkbox" name="excel_fields[]" id="re_located_to"
                                                value="re_located_to" class="form-check-input checkBoxClass">
                                            <label class="form-check-label" for="re_located_to">
                                                Re located to
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="custom-control custom-checkbox mb-3">
                                            <input type="checkbox" name="excel_fields[]" id="physical_verification_date"
                                                value="physical_verification_date" class="form-check-input checkBoxClass">
                                            <label class="form-check-label" for="physical_verification_date">
                                                Physical Verification Date
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="custom-control custom-checkbox mb-3">
                                            <input type="checkbox" name="excel_fields[]" id="physical_verification_date_2"
                                                value="physical_verification_date_2" class="form-check-input checkBoxClass">
                                            <label class="form-check-label" for="physical_verification_date_2">
                                                Physical Verification Date 2
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="custom-control custom-checkbox mb-3">
                                            <input type="checkbox" name="excel_fields[]" id="vehicle_type"
                                                value="vehicle_type" class="form-check-input checkBoxClass">
                                            <label class="form-check-label" for="vehicle_type">
                                                Vehicle Type
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="custom-control custom-checkbox mb-3">
                                            <input type="checkbox" name="excel_fields[]" id="vehicle_registration_no"
                                                value="vehicle_registration_no" class="form-check-input checkBoxClass">
                                            <label class="form-check-label" for="vehicle_registration_no">
                                                Vehicle Registration No
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-sm-12">
                                        <div class="custom-control custom-checkbox mb-3">
                                            <input type="checkbox" name="excel_fields[]" id="chesis_no"
                                                value="chesis_no" class="form-check-input checkBoxClass">
                                            <label class="form-check-label" for="chesis_no">
                                                Chesis No
                                            </label>
                                        </div>
                                    </div>
                                    @foreach ($columns as $key => $column)
                                        @if ($key > 0 && $column!='building_code_id' && $column!='asset_type_id' && $column!='asset_json')
                                            <div class="col-md-6 col-sm-12">
                                                <div class="custom-control custom-checkbox mb-3">
                                                    <input type="checkbox" name="excel_fields[]" id="{{ $column }}"
                                                        value="{{ $column }}" class="form-check-input checkBoxClass">
                                                    <label class="form-check-label" for="{{ $column }}">
                                                        {{ ucfirst(str_replace('_', ' ', $column)) }}
                                                    </label>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach

                                </div>
                            </div>
                        </div>

                        <div class="m-t-15" id="statusForm">
                            <div class="modal-footer">
                                <button type="button" id="custom_report_btn"
                                    class="btn btn-primary btn-raised waves-effect">
                                    Download Report
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{ Form::close() }}
            <!-- Default box -->
            <div class="card">
                <form action="{{route('updateRequest')}}" method="get" onsubmit='return confirm("confirm action")'>
                @csrf
                @method('get')
                <input type="hidden" name="tagName" value="manage_assets">
                <div class="float-left">
                    <a href="{{ $add_new_url }}" class="btn btn-success rounded-0" style="margin:10px;"><i class="fa fa-plus"></i> Add</a>
                    <a href="{{ route('admin.assets.import') }}" class="btn btn-success rounded-0" style="margin:10px;"><i class="fa fa-upload"></i>Import</a>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#printQrcodeModal">
                        Print Qrcode
                    </button>
                    <input type="submit" class="btn btn-danger btn-flat" value="delete" name="delete" style="margin:10px;">
                </div>
                <div class="card-body p-0" style="display: block;">
                    <table class="projects table table-bordered table-hover table-striped">
                        <thead class="ty-1">
                            <tr>
                                {{-- <th style="width:5%">S No.</th> --}}
                                <th style="width:5%"><input type="checkbox" id="selecctall"></th>
                                <th style="width:15%">Building</th>
                                <th style="width:15%">Asset Name</th>
                                <th style="width:10%">Asset Type</th>
                                <th style="width:15%">Asset Unique Code </th>
                                <th style="width:10%">Created by </th>
                                <th style="width:10%">Status </th>
                                <th style="width:15%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $i = ($aRows->perPage() * ($aRows->currentPage() - 1)) + 1;
                             ?>
                            @foreach ($aRows as $key => $item)
                                <tr>
                                    @php
                                        $asset_details = json_decode($item->asset_json, true);
                                    @endphp
                                    {{-- <td>{{ $i + $key}}</td> --}}
                                    <td><input type="checkbox" class="checkCK_id" name="ck_id[]" value="{{$item->id}}"></td>
                                    <td>{{ isset($item->building_block->building->name)?$item->building_block->building->name:'' }}</td>
                                    <td>{{ isset($asset_details['asset_name'])?$asset_details['asset_name']:'' }}</td>
                                    <td>{{ $item->asset_type ? $item->asset_type->name : '' }}</td>
                                    @if(isset($item->building->code))
                                      <td>{{ $item->building->code.'/'.(isset($item->asset_type->code)?$item->asset_type->code:'').'/'.$item->unique_id }}</td>
                                    @else
                                        <td>{{ $item->unique_id }}</td>
                                    @endif
                                    <td>{{ $helperObj::findUser($item->created_by)->name }}</td>
                                    <td>{!! ($item->status == 1) ? '<span class="badge bg-success">Approve</span>' : (($item->status == 0) ?'<span class="badge bg-warning ">Pending</span>':'<span class="badge bg-danger">Reject</span>') !!}</td>
                                    <td>
                                        <a  onclick="approve({{ $item->id }});" title="Approve" type="button" data-toggle="modal" data-target="#myModal" class="btn btn-primary  btn-xs">
                                            <i class="fa fa-thumbs-up"></i>

                                        </a>
                                        <a href="{{ route('admin.assets.show', $item->id) }}"
                                            class="btn btn-primary  btn-xs" title="View"><i class="fa fa-eye"></i></a>
                                        <a href="{{ route('admin.assets.edit', $item->id) }}"
                                            class="btn btn-primary  btn-xs" title="Edit"><i class="fa fa-edit" ></i></a>
                                        <a href="{{ route('admin.assets.qrcode', $item->id) }}"
                                            class="btn btn-primary mt-1 btn-xs" title="QRCode"><i class="fa fa-qrcode"></i></a>
                                        <form action="{{ route('admin.assets.destroy', ['asset' => $item->id]) }}" method="POST"  style="display: inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-primary btn-danger btn-xs" title="Delete"><i class="fa fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="text-center">
                        {!! $aRows->appends(Request::except('page'))->render() !!}
                    </div>
                </div>
                {{ Form::close() }}
            </div>
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <!-- Modal -->
    <div class="modal fade bd-example-modal-lg" id="printQrcodeModal" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
            <div class="modal-content modal-lg">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalScrollableTitle">Asset Qrcode List</h5>
                    &nbsp; &nbsp; &nbsp;<input type="checkbox" name="assets" id="checkAll" />
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row" id='printMe'>
                        @foreach ($aRows as $key => $asset)
                            <div class="col-md-6 col-sm-12 col-xs-12 asset_div" id="asset{{ $key }}">
                                <div class="card card-primary card-outline">
                                    <div class="pd-2 text-center">
                                        <input type="checkbox" name="asset" class="checkbox_asset" value="{{ $key }}" />
                                    </div>
                                    <table  class="projects table table-bordered table-hover table-striped show_details mb-0">
                                        <tr>
                                            <th rowspan="4" class="w-0" style="vertical-align: middle">
                                                <div class="border_right pr-2">
                                                    @if(isset($asset->building->code))
                                                    {!! QrCode::generate($asset->unique_id ?(isset($asset->building->code)?$asset->building->code:'').'/'.(isset($asset->asset_type->code)?$asset->asset_type->code:'').'/'.$asset->unique_id : '') !!}
                                                    @else
                                                    {!! QrCode::generate($asset->unique_id) !!}

                                                    @endif
                                                </div>
                                            </th>
                                            <th colspan="2" class="border_bottom w-100">
                                                @if(isset($asset->building->code))
                                                    <strong>{{ $asset->unique_id ? (isset($asset->building->code)?$asset->building->code:'').'/'.(isset($asset->asset_type->code)?$asset->asset_type->code:'').'/'.$asset->unique_id : 'N/A' }}</strong>
                                                @else
                                                    <strong>{{$asset->unique_id }}</strong>
                                                @endif
                                            </th>
                                        </tr>
                                        <tr class="pl-2">
                                            @if(isset($asset->building->code))
                                            <th>Building:</th>
                                            <td>{{ isset($asset->building_block->building->name)?$asset->building_block->building->name:'' }}</td>
                                            @else
                                            <th>Chesis No:</th>
                                            <td style="width: 110px; word-wrap: break-word; word-break: break-word;">{{ isset(json_decode($asset->asset_json)->chesis_no)?json_decode($asset->asset_json)->chesis_no:'' }}</td>
                                            @endif
                                        </tr>
                                        <tr class="pl-2">
                                            <th>Type:</th>
                                            <td>{{ $asset->asset_type? $asset->asset_type->name : 'N/A'}}</td>
                                        </tr>
                                        <tr class="pl-2">
                                            <th>Name:</th>
                                            <td>{{ isset(json_decode($asset->asset_json)->asset_name)?json_decode($asset->asset_json)->asset_name:'' }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="printDiv('printMe')">Print</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('add-script')
<div class="modal fade" id="myModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
    {{ Form::open(['url' => route('admin.update_status'), 'method' => 'POST']) }}
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="defaultModalLabel"> Application Status</h4>
                <button type="button" class="close btn-raised" data-dismiss="modal">×</button>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <label>Action</label>
                    <div class="col-md-8 col-sm-12">
                        <label class="btn btn-primary btn-raised waves-effect font-bold approve">
                            <input type="radio" name="status" class="mr-2 status" value="1" required="">
                            Approve
                        </label>
                        <label class="btn btn-warning btn-raised waves-effect font-bold reject">
                            <input type="radio" name="status" class="mr-2 status" value="2" required="">
                            Reject
                        </label>
                    </div>
                </div>
                <input id="asset_id" name="asset_id" type="hidden" value="">
                {{-- <div class="row">
                    <div class="col-lg-12">

                        <input name="approved_on" type="hidden" value="{{ date('d-m-Y H:i:s') }}">
                        <label for="reason" class="form-label">Remark</label>
                        <div class="form-group row">
                            <div class="col-lg-12">
                                <div class="input-group">
                                    <textarea class="form-control" name="approve_reason" rows="2" id="approve_reason"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> --}}

            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary btn-raised pull-right waves-effect"
                    onclick="return confirm('Are you sure you want to proceed?');">Update</button>
            </div>
        </div>
        {{ Form::close() }}
    </div>
</div>
    <script>
        $(function() {
            $("#checkAll").change(function() {
                $("input:checkbox").prop('checked', $(this).prop("checked"));
            });
        });
        function approve(id) {
            $('#asset_id').val(id);

        }

        function printDiv(divName) {
            $('input[name="asset"]').each(function() {
                if ($(this).is(':checked')) {
                    $('#asset' + this.value).show();
                    console.log(this.value);

                } else {
                    $('#asset' + this.value).hide();
                }
            });
            $(".checkbox_asset").hide();
            var divToPrint = document.getElementById(divName);
            var htmlToPrint = '' +
                '<style type="text/css">' +
                '.card {' +
                    'position: relative;' +
                    'display: flex;' +
                    'flex-direction: column;' +
                    'min-width: 0;' +
                    'word-wrap: break-word;' +
                'background-color: #fff;' +
                    'background-clip: border-box;' +
                    'border: 1px solid rgba(0, 0, 0, 0.125);' +
                    'border-radius: 0.25rem;' +
                '}' +
                '.card-primary.card-outline {'+
                    'border-top: 3px solid #007bff;'+
                '}'+
                '.card {'+
                    'box-shadow: 0 0 1px rgba(0, 0, 0, 0.125), 0 1px 3px rgba(0, 0, 0, 0.2);'+
                    'margin-bottom: 1rem;'+
                '}'+
                '.text-center {'+
                     'text-align: center !important;'+
                '}'+
                '.table-bordered th, .table-bordered td {'+
                    'border: 1px solid #dee2e6;'+
                '}'+
                'table {'+
                'border-collapse: collapse;'+
                '}'+
                '.col-md-6 {'+
                    'flex: 0 0 50%;'+
                    'max-width: 50%;'+
                '}'+


                '}' +
                '</style>';
            htmlToPrint += divToPrint.outerHTML;
            newWin = window.open("");
            newWin.document.write("<h3 align='center'>Asset Qrcode List</h3>");
            newWin.document.write(htmlToPrint);
            newWin.print();
            newWin.close();
            $(".checkbox_asset").show();
            $(".asset_div").show();
            // var printContents = document.getElementById(divName).innerHTML;
            // var originalContents = document.body.innerHTML;
            // document.body.innerHTML = printContents;
            // window.print();
            // document.body.innerHTML = originalContents;
        }
        $(function() {

            $("#search").click(function() {
                $("input[name='short_report']").val('0');
                $("input[name='detail_report']").val('0');
                $("input[name='custom_report']").val('0');
                $("input[name='exptype']").remove();
                $('#btfform').submit();
            });
            $("#select_all").click(function() {
                $(".checkBoxClass").prop('checked', $(this).prop('checked'));
            });
            $("#custom_report_btn").click(function() {
                $("input[name='custom_report']").val('1');
                $("input[name='detail_report']").val('0');
                $("input[name='short_report']").val('0');
                $('#btfform').append('<input type="hidden" name="exptype" value="excel" />').submit();
            });

            $('.report').click(function() {
                if ($(this).attr("data-report") == 'detail_report') {
                    $("input[name='detail_report']").val('1');
                    $("input[name='short_report']").val('0');
                    $("input[name='custom_report']").val('0');
                }
                if ($(this).attr("data-report") == 'short_report') {
                    $("input[name='short_report']").val('1');
                    $("input[name='detail_report']").val('0');
                    $("input[name='custom_report']").val('0');
                }
                $('#btfform').append('<input type="hidden" name="exptype" value="excel" />').submit();
            });
        });


        $('#btn_refresh').click(function() {
            $('[name="start_date"]').val('');
            $('[name="end_date"]').val('');
            $('[name="search"]').val('');
            $('[name="status"]').val('');
            $("[name='page_content']").val(' ');
            $(this).prev().trigger("click");
        });
    </script>
    <style type="text/css">
        @media print{

.card-primary.card-outline {
    border-top: 3px solid #007bff;
}
.card {
    position: relative;
    display: flex;
    flex-direction: column;
    min-width: 0;
    word-wrap: break-word;
    background-color: #fff;
    background-clip: border-box;
    border: 1px solid rgba(0, 0, 0, 0.125);
    border-radius: 0.25rem;
}
.card {
    box-shadow: 0 0 1px rgba(0, 0, 0, 0.125), 0 1px 3px rgba(0, 0, 0, 0.2);
    margin-bottom: 1rem;
}
        }

    </style>
@endpush
