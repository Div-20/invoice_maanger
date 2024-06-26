@extends('layouts.app')
@php
    $page_title = $aRow ? 'Edit Asset' : 'Add New Asset';
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
                        <h1>{{ $page_title }}</h1>
                    </div>

                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">


            <div class="container-fluid">
                <div class="card card-primary card-outline">

                    <!-- Default box -->
                    <div class="card-body">
                        @if ($aRow)
                            {{Form::open(array('url' =>route('user.assets.update',$aRow->id), 'files' => true))}}
                            @method('PATCH')
                        @else
                            {{Form::open(array('url' =>route('user.assets.store'), 'method' => 'post', 'files' => true))}}

                        @endif
                        <div class="row">
                            <div class="form-group col-lg-6">
                                <label>Select Asset Type</label>
                                <select name="asset_type" class="form-control @error('room_no') is-invalid @enderror" id="asset_type">
                                    <option>--Please Select--</option>
                                    @foreach ($asset_type as $item)
                                        <option value="{{$item->name}}" >{{$item->name}}</option>
                                    @endforeach

                                </select>

                                @error('asset_type')
                                    <label class="col-form-label" for="inputError"><i class="fa fa-times-circle text-danger "></i>&nbsp;&nbsp;{{ $message }}</label>
                                @enderror
                            </div>
                            <div class="form-group col-lg-6">
                            </div>



                            <div id="other_asset" class="col-lg-12 other_asset row">
                                <div class="form-group col-lg-6">
                                    <label>Select Department</label>
                                    <select name="department_id" class="form-control @error('room_no') is-invalid @enderror" id="department_id">
                                        <option>--Please Select--</option>
                                        @foreach ($departments as $item)
                                            <option value="{{$item->id}}" >{{$item->name}}</option>
                                        @endforeach

                                    </select>

                                    @error('department_id')
                                        <label class="col-form-label" for="inputError"><i class="fa fa-times-circle text-danger "></i>&nbsp;&nbsp;{{ $message }}</label>
                                    @enderror
                                </div>
                                <div class="form-group col-lg-6">
                                    <label>Select Building</label>
                                    <select name="building_id" class="form-control @error('room_no') is-invalid @enderror" id="building_id">
                                        <option>--Please Select--</option>
                                        @foreach ($buildings as $item)
                                            <option value="{{$item->id}}">{{$item->name}}</option>
                                        @endforeach

                                    </select>

                                    @error('building_id')
                                        <label class="col-form-label" for="inputError"><i class="fa fa-times-circle text-danger "></i>&nbsp;&nbsp;{{ $message }}</label>
                                    @enderror
                                </div>
                                <div class="form-group col-lg-6">
                                    <label>Select Floor</label>
                                    <select name="floor_id" class="form-control @error('room_no') is-invalid @enderror" id="floor_id">
                                        <option>--Please Select--</option>
                                        @foreach ($floors as $item)
                                            <option value="{{$item->id}}" >{{$item->name}}</option>
                                        @endforeach

                                    </select>

                                    @error('floor_id')
                                        <label class="col-form-label" for="inputError"><i class="fa fa-times-circle text-danger "></i>&nbsp;&nbsp;{{ $message }}</label>
                                    @enderror
                                </div>
                                <div class="form-group col-lg-6">
                                    <label>Room No.</label>
                                    <input type=" text" class="form-control @error('room_no') is-invalid @enderror" name='room_no' value="{{ $aRow->room_no ?? old('room_no') }}" placeholder="Enter Room No.">
                                    @error('room_no')
                                        <label class="col-form-label" for="inputError"><i class="fa fa-times-circle text-danger "></i>&nbsp;&nbsp;{{ $message }}</label>
                                    @enderror
                                </div>
                                <div class="form-group col-lg-6">
                                    <label>Asset Name</label>
                                    <input type=" text" class="form-control @error('asset_name') is-invalid @enderror" name='asset_name' value="{{ $aRow->asset_name ?? old('asset_name') }}" placeholder="Enter Asset Name">
                                    @error('asset_name')
                                        <label class="col-form-label" for="inputError"><i class="fa fa-times-circle text-danger "></i>&nbsp;&nbsp;{{ $message }}</label>
                                    @enderror
                                </div>
                                <div class="form-group col-lg-6">
                                    <label>Made of</label>
                                    <input type=" text" class="form-control @error('made_of') is-invalid @enderror" name='made_of' value="{{ $aRow->made_of ?? old('made_of') }}" placeholder="Asset made of">
                                    @error('made_of')
                                        <label class="col-form-label" for="inputError"><i class="fa fa-times-circle text-danger "></i>&nbsp;&nbsp;{{ $message }}</label>
                                    @enderror
                                </div>
                                <div class="form-group col-lg-6">
                                    <label>Description</label>
                                    <input type=" text" class="form-control @error('detail') is-invalid @enderror" name='detail' value="{{ $aRow->detail ?? old('detail') }}" placeholder="Asset Description">
                                    @error('detail')
                                        <label class="col-form-label" for="inputError"><i class="fa fa-times-circle text-danger "></i>&nbsp;&nbsp;{{ $message }}</label>
                                    @enderror
                                </div>

                            </div>
                            <div id="vhl_asset" class="row col-lg-12 vhl_asset">
                                <div class="form-group col-lg-6">
                                    <label>Vehicle Type</label>
                                    <input type=" text" class="form-control @error('vehicle_type') is-invalid @enderror" name='vehicle_type' value="{{ $aRow->vehicle_type ?? old('vehicle_type') }}" placeholder="Enter Vehicle Type">
                                    @error('vehicle_type')
                                        <label class="col-form-label" for="inputError"><i class="fa fa-times-circle text-danger "></i>&nbsp;&nbsp;{{ $message }}</label>
                                    @enderror
                                </div>
                                <div class="form-group col-lg-6">
                                    <label>Vehicle Registration No.</label>
                                    <input type=" text" class="form-control @error('reg_no') is-invalid @enderror" name='reg_no' value="{{ $aRow->reg_no ?? old('reg_no') }}" placeholder="Enter Vehicle Registration No.">
                                    @error('reg_no')
                                        <label class="col-form-label" for="inputError"><i class="fa fa-times-circle text-danger "></i>&nbsp;&nbsp;{{ $message }}</label>
                                    @enderror
                                </div>
                                <div class="form-group col-lg-6">
                                    <label>Chesis No.</label>
                                    <input type=" text" class="form-control @error('chesis_no') is-invalid @enderror" name='chesis_no' value="{{ $aRow->chesis_no ?? old('chesis_no') }}" placeholder="Enter Chesis No.">
                                    @error('chesis_no')
                                        <label class="col-form-label" for="inputError"><i class="fa fa-times-circle text-danger "></i>&nbsp;&nbsp;{{ $message }}</label>
                                    @enderror
                                </div>
                                <div class="form-group col-lg-6">
                                    <label>Insurance policy No</label>
                                    <input type=" text" class="form-control @error('policy_no') is-invalid @enderror" name='policy_no' value="{{ $aRow->policy_no ?? old('policy_no') }}" placeholder="Enter Insurance policy No">
                                    @error('policy_no')
                                        <label class="col-form-label" for="inputError"><i class="fa fa-times-circle text-danger "></i>&nbsp;&nbsp;{{ $message }}</label>
                                    @enderror
                                </div>
                                <div class="form-group col-lg-6">
                                    <label>Renewal Date</label>
                                    <input type=" date" class="form-control @error('renewal_date') is-invalid @enderror" name='renewal_date' value="{{ $aRow->renewal_date ?? old('renewal_date') }}" placeholder="Enter Renewal Date">
                                    @error('renewal_date')
                                        <label class="col-form-label" for="inputError"><i class="fa fa-times-circle text-danger "></i>&nbsp;&nbsp;{{ $message }}</label>
                                    @enderror
                                </div>
                                <div class="form-group col-lg-6">
                                    <label>Insurance Company</label>
                                    <input type=" text" class="form-control @error('insurance_company') is-invalid @enderror" name='insurance_company' value="{{ $aRow->insurance_company ?? old('insurance_company') }}" placeholder="Enter Insurance Company">
                                    @error('insurance_company')
                                        <label class="col-form-label" for="inputError"><i class="fa fa-times-circle text-danger "></i>&nbsp;&nbsp;{{ $message }}</label>
                                    @enderror
                                </div>
                                <div class="form-group col-lg-6">
                                    <label>Sum Insurred</label>
                                    <input type=" text" class="form-control @error('sum_insurred') is-invalid @enderror" name='sum_insurred' value="{{ $aRow->sum_insurred ?? old('sum_insurred') }}" placeholder="Sum Insurred">
                                    @error('sum_insurred')
                                        <label class="col-form-label" for="inputError"><i class="fa fa-times-circle text-danger "></i>&nbsp;&nbsp;{{ $message }}</label>
                                    @enderror
                                </div>
                                <div class="form-group col-lg-6">
                                    <label>Premium</label>
                                    <input type=" text" class="form-control @error('premium') is-invalid @enderror" name='premium' value="{{ $aRow->premium ?? old('premium') }}" placeholder="Enter Premium">
                                    @error('sum_insurred')
                                        <label class="col-form-label" for="inputError"><i class="fa fa-times-circle text-danger "></i>&nbsp;&nbsp;{{ $message }}</label>
                                    @enderror
                                </div>
                                <div class="form-group col-lg-6">
                                    <label>Polution (PUC) valid  upto </label>
                                    <input type="date" class="form-control @error('polution_valid_upto') is-invalid @enderror" name='polution_valid_upto' value="{{ $aRow->polution_valid_upto ?? old('polution_valid_upto') }}" placeholder="Enter PUC Validity">
                                    @error('polution_valid_upto')
                                        <label class="col-form-label" for="inputError"><i class="fa fa-times-circle text-danger "></i>&nbsp;&nbsp;{{ $message }}</label>
                                    @enderror
                                </div>
                                <div class="form-group col-lg-6">
                                    <label>Renewal Date</label>
                                    <input type="date" class="form-control @error('renewal_date') is-invalid @enderror" name='renewal_date' value="{{ $aRow->renewal_date ?? old('renewal_date') }}" placeholder="Enter PUC Validity">
                                    @error('renewal_date')
                                        <label class="col-form-label" for="inputError"><i class="fa fa-times-circle text-danger "></i>&nbsp;&nbsp;{{ $message }}</label>
                                    @enderror
                                </div>

                            </div>
                            <div class="form-group col-lg-6">
                                <label>Manufacturer</label>
                                <input type=" text" class="form-control @error('make') is-invalid @enderror" name='make' value="{{ $aRow->make ?? old('make') }}" placeholder="Asset Manufacturer">
                                @error('make')
                                    <label class="col-form-label" for="inputError"><i class="fa fa-times-circle text-danger "></i>&nbsp;&nbsp;{{ $message }}</label>
                                @enderror
                            </div>
                            <div class="form-group col-lg-6">
                                <label>Model</label>
                                <input type=" text" class="form-control @error('model') is-invalid @enderror" name='model' value="{{ $aRow->model ?? old('model') }}" placeholder="Asset Model">
                                @error('model')
                                    <label class="col-form-label" for="inputError"><i class="fa fa-times-circle text-danger "></i>&nbsp;&nbsp;{{ $message }}</label>
                                @enderror
                            </div>
                            <div class="form-group col-lg-6">
                                <label>Capacity</label>
                                <input type=" text" class="form-control @error('capacity') is-invalid @enderror" name='capacity' value="{{ $aRow->capacity ?? old('capacity') }}" placeholder="Asset Capacity">
                                @error('capacity')
                                    <label class="col-form-label" for="inputError"><i class="fa fa-times-circle text-danger "></i>&nbsp;&nbsp;{{ $message }}</label>
                                @enderror
                            </div>
                            <div class="form-group col-lg-6">
                                <label>Year of MFG</label>
                                <input type="date" class="form-control" placeholder="Select date" name="year_of_mfg">
                                @error('year_of_mfg')
                                    <label class="col-form-label" for="inputError"><i class="fa fa-times-circle text-danger "></i>&nbsp;&nbsp;{{ $message }}</label>
                                @enderror
                            </div>
                            <div class="form-group col-lg-6">
                                <label>Year of Purchase/Installation</label>
                                <input type="date" class="form-control" placeholder="Select date" name="year_of_purchase">
                                @error('year_of_purchase')
                                    <label class="col-form-label" for="inputError"><i class="fa fa-times-circle text-danger "></i>&nbsp;&nbsp;{{ $message }}</label>
                                @enderror
                            </div>
                            <div class="form-group col-lg-6">
                                <label>Working Condition</label>
                                <select name="working_condition" class="form-control @error('working_condition') is-invalid @enderror" id="working_condition">
                                    <option value="Working">Working</option>
                                    <option value="Non-working">Non-working</option>
                                    <option value="Discarded">Discarded</option>
                                    <option value="sold off">Sold off</option>
                                    <option value="Transferred">Transferred</option>
                                </select>
                                @error('working_condition')
                                    <label class="col-form-label" for="inputError"><i class="fa fa-times-circle text-danger "></i>&nbsp;&nbsp;{{ $message }}</label>
                                @enderror
                            </div>

                            <div class="form-group col-lg-6">
                                <label>Name</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" name='name' value="{{ $aRow->name ?? old('name') }}" placeholder="Name">
                                @error('name')
                                    <label class="col-form-label" for="inputError"><i class="fa fa-times-circle text-danger "></i>&nbsp;&nbsp;{{ $message }}</label>
                                @enderror
                            </div>
                            <div class="form-group col-lg-6">
                                <label>Ref No.</label>
                                <input type="text" class="form-control @error('ref_no') is-invalid @enderror" name='ref_no' value="{{ $aRow->ref_no ?? old('ref_no') }}" placeholder="Ref No.">
                                @error('ref_no')
                                    <label class="col-form-label" for="inputError"><i class="fa fa-times-circle text-danger "></i>&nbsp;&nbsp;{{ $message }}</label>
                                @enderror
                            </div>
                            <div class="form-group col-lg-6">
                                <label>Allocated to</label>
                                <input type="text" class="form-control @error('allocated_to') is-invalid @enderror" name='allocated_to' value="{{ $aRow->allocated_to ?? old('allocated_to') }}" placeholder="Allocated to">
                                @error('allocated_to')
                                    <label class="col-form-label" for="inputError"><i class="fa fa-times-circle text-danger "></i>&nbsp;&nbsp;{{ $message }}</label>
                                @enderror
                            </div>
                            <div class="form-group col-lg-6">
                                <label>Re-located to</label>
                                <input type="text" class="form-control @error('re_located_to') is-invalid @enderror" name='re_located_to' value="{{ $aRow->re_located_to ?? old('re_located_to') }}" placeholder="Re-located to">
                                @error('re_located_to')
                                    <label class="col-form-label" for="inputError"><i class="fa fa-times-circle text-danger "></i>&nbsp;&nbsp;{{ $message }}</label>
                                @enderror
                            </div>
                            <div class="form-group col-lg-12">
                                <label>Remark</label>
                                <textarea class="form-control @error('working_condition') is-invalid @enderror" id="remark" rows="3"></textarea>
                                @error('working_condition')
                                    <label class="col-form-label" for="inputError"><i class="fa fa-times-circle text-danger "></i>&nbsp;&nbsp;{{ $message }}</label>
                                @enderror
                            </div>

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
        $(document).ready(function (){
            $('#vhl_asset').hide();
            $('#other_asset').show();
            $('#asset_type').on('change', function() {
                var asset_type = $(this).val();
                console.log(asset_type);
                if(asset_type == 'Vehicle'){
                    $('#vhl_asset').show();
                    $('#other_asset').hide();
                }else{
                    $('#other_asset').show();
                    $('#vhl_asset').hide();
                }
            });
            // $('#department_id').on('change', function(){
            //     // alert("Hello");
            // });
        });
    </script>
@endpush



