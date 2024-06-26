@extends('admin.layout.admin-layout')
@php
    $page_title = 'Asset Review';
    $add_new_url = route('admin.assets.create');
    $aAuth = Auth::guard('admin')->user();
@endphp
@section('title')
    {{ $page_title }}
@endsection
@section('nav-manu-content')
    <li class="nav-item d-none d-sm-inline-block">
        <a href="{{ route('admin.dashboard') }}" class="nav-link">Home</a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link"> {{ $page_title }}</a>
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
            {{ Form::open(['url' => route('admin.review_list'), 'method' => 'GET', 'id' => 'btfform']) }}
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
                    </div>
                </div>

            </div>


            {{ Form::close() }}
            <!-- Default box -->
            <div class="card">
                @method('get')

                <div class="card-body p-0" style="display: block;">
                    <table class="projects table table-bordered table-hover table-striped">
                        <thead class="ty-1">
                            <tr>
                                <th style="width:5%">S No.</th>
                                <th style="width:15%">Asset Unique Code</th>
                                <th style="width:15%">Asset Name</th>
                                <th style="width:15%">Physical verification User</th>
                                <th style="width:15%">Status</th>
                                <th style="width:20%">Review</th>

                                {{-- <th style="width:15%">Action</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $i = ($asset_review->perPage() * ($asset_review->currentPage() - 1)) + 1;
                             ?>
                            @foreach ($asset_review as $key => $item)
                                <tr>
                                    @php
                                        $asset_details = json_decode($item->asset->asset_json, true);
                                    @endphp
                                    <td>{{ $i + $key}}</td>
                                    <td>{{ $item->asset->unique_id ? $item->asset->unique_id : '' }}</td>
                                    <td>{{ isset($asset_details['asset_name'])?$asset_details['asset_name']:'' }}</td>
                                    <td>{{ $item->user->name }}</td>
                                    <td>{!! ($item->status == 2) ? '<span class="badge bg-success">All correct</span>' : '<span class="badge bg-danger">Not correct</span>'!!}</td>
                                    <td>{{ $item->review }}</td>
                                    {{-- <td>
                                        <a href="" class="btn btn-primary btn-xs" title="Review">Review</a>
                                        <a href="{{ route('admin.assets.show', $item->id) }}"
                                            class="btn btn-primary  btn-xs" title="View"><i class="fa fa-eye"></i></a>
                                        <a href="{{ route('admin.assets.edit', $item->id) }}"
                                            class="btn btn-primary  btn-xs" title="Edit"><i class="fa fa-edit" ></i></a>
                                        <a href="{{ route('admin.assets.qrcode', $item->id) }}"
                                            class="btn btn-primary mt-1 btn-xs" title="QRCode"><i class="fa fa-qrcode"></i></a>
                                        <form action="{{ route('admin.assets.destroy', ['asset' => $item->id]) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-primary btn-danger btn-xs" title="Delete"><i class="fa fa-trash"></i></button>
                                        </form> -
                                    </td> --}}
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="text-center">
                        {!! $asset_review->appends(Request::except('page'))->render() !!}
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <!-- Modal -->
    <div class="modal fade bd-example-modal-lg" id="printQrcodeModal" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalScrollableTitle">Asset Qrcode List</h5>
                    &nbsp; &nbsp; &nbsp;<input type="checkbox" name="assets" id="checkAll" />
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row" id='printMe'>

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
    <script>

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
@endpush
