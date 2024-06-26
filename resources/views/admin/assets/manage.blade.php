@extends('admin.layout.admin-layout')
@php
    $page_title = $aRow ? 'Edit Asset' : 'Add New Asset';
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
        <a href="{{ route('admin.category.index') }}" class="active nav-link">Back</a>
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
                <div class="card card-primary card-outline">

                    <!-- Default box -->
                    <div class="card-body">
                        @if ($aRow)
                            {{Form::open(array('url' =>route('admin.assets.update',$aRow->id), 'files' => true))}}
                            @method('PATCH')
                        @else
                            {{Form::open(array('url' =>route('admin.assets.store'), 'method' => 'post', 'files' => true))}}

                        @endif
                        <div class="row">
                            <div class="form-group col-lg-6">
                                <label>Select Asset Type</label>
                                <select name="asset_type" class="form-control @error('room_no') is-invalid @enderror" id="asset_type">
                                    <option value="">--Please Select--</option>
                                    @foreach ($asset_type as $item)
                                        <option value="{{$item->name}}" <?php echo (isset($aRow->asset_type_id) && $aRow->asset_type_id==$item->id)?'selected':'' ?>>{{$item->name}}</option>
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
                                        <option value="">--Please Select--</option>
                                        @foreach ($departments as $item)
                                            <option value="{{$item->id}}" <?php echo ($aRow && isset(json_decode($aRow->asset_json)->department) && json_decode($aRow->asset_json)->department==$item->name)?'selected':'' ?>>{{$item->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('department_id')
                                        <label class="col-form-label" for="inputError"><i class="fa fa-times-circle text-danger "></i>&nbsp;&nbsp;{{ $message }}</label>
                                    @enderror
                                </div>
                                <div class="form-group col-lg-6">
                                    <label>Select Building</label>
                                    <select name="building_id" class="form-control @error('room_no') is-invalid @enderror" id="building_id">
                                        <option value="">--Please Select--</option>
                                        @foreach ($buildings as $item)
                                        <option value="{{$item->id}}" <?php echo ($aRow && isset(json_decode($aRow->asset_json)->building) && json_decode($aRow->asset_json)->building==$item->name)?'selected':'' ?>>{{$item->name}}</option>
                                    @endforeach
                                    </select>

                                    @error('building_id')
                                        <label class="col-form-label" for="inputError"><i class="fa fa-times-circle text-danger "></i>&nbsp;&nbsp;{{ $message }}</label>
                                    @enderror
                                </div>
                                <div class="form-group col-lg-6">
                                    <label>Select Floor</label>
                                    <select name="floor_id" class="form-control @error('room_no') is-invalid @enderror" id="floor_id">
                                        <option value="">--Please Select--</option>
                                        @foreach ($floors as $item)
                                        <option value="{{$item->id}}" <?php echo ($aRow && isset(json_decode($aRow->asset_json)->floor) && json_decode($aRow->asset_json)->floor==$item->name)?'selected':'' ?>>{{$item->name}}</option>
                                    @endforeach
                                    </select>

                                    @error('floor_id')
                                        <label class="col-form-label" for="inputError"><i class="fa fa-times-circle text-danger "></i>&nbsp;&nbsp;{{ $message }}</label>
                                    @enderror
                                </div>
                                <div class="form-group col-lg-6">
                                    <label>Room No.</label>
                                    <input type=" text" class="form-control @error('room_no') is-invalid @enderror" name='room_no' value="{{ $aRow && isset(json_decode($aRow->asset_json)->room_no)?json_decode($aRow->asset_json)->room_no:old('room_no') }}" placeholder="Enter Room No.">
                                    @error('room_no')
                                        <label class="col-form-label" for="inputError"><i class="fa fa-times-circle text-danger "></i>&nbsp;&nbsp;{{ $message }}</label>
                                    @enderror
                                </div>
                                <div class="form-group col-lg-6">
                                    <label>Asset Name</label>
                                    <input type=" text" class="form-control @error('asset_name') is-invalid @enderror" name='asset_name' value="{{$aRow && isset(json_decode($aRow->asset_json)->asset_name)?json_decode($aRow->asset_json)->asset_name:old('asset_name') }}" placeholder="Enter Asset Name">
                                    @error('asset_name')
                                        <label class="col-form-label" for="inputError"><i class="fa fa-times-circle text-danger "></i>&nbsp;&nbsp;{{ $message }}</label>
                                    @enderror
                                </div>
                                <div class="form-group col-lg-6">
                                    <label>Made of</label>
                                    <input type=" text" class="form-control @error('made_of') is-invalid @enderror" name='made_of' value="{{ $aRow && isset(json_decode($aRow->asset_json)->made_of)?json_decode($aRow->asset_json)->made_of:old('made_of') }}" placeholder="Asset made of">
                                    @error('made_of')
                                        <label class="col-form-label" for="inputError"><i class="fa fa-times-circle text-danger "></i>&nbsp;&nbsp;{{ $message }}</label>
                                    @enderror
                                </div>
                                <div class="form-group col-lg-6">
                                    <label>Description</label>
                                    <input type=" text" class="form-control @error('detail') is-invalid @enderror" name='detail' value="{{ $aRow && isset(json_decode($aRow->asset_json)->detai)?json_decode($aRow->asset_json)->detail:old('detail') }}" placeholder="Asset Description">
                                    @error('detail')
                                        <label class="col-form-label" for="inputError"><i class="fa fa-times-circle text-danger "></i>&nbsp;&nbsp;{{ $message }}</label>
                                    @enderror
                                </div>

                            </div>
                            <div id="vhl_asset" class="row col-lg-12 vhl_asset">
                                <div class="form-group col-lg-6">
                                    <label>Vehicle Type</label>
                                    <input type=" text" class="form-control @error('vehicle_type') is-invalid @enderror" name='vehicle_type' value="{{ $aRow && isset(json_decode($aRow->asset_json)->vehicle_type)?json_decode($aRow->asset_json)->vehicle_type:old('vehicle_type') }}" placeholder="Enter Vehicle Type">
                                    @error('vehicle_type')
                                        <label class="col-form-label" for="inputError"><i class="fa fa-times-circle text-danger "></i>&nbsp;&nbsp;{{ $message }}</label>
                                    @enderror
                                </div>
                                <div class="form-group col-lg-6">
                                    <label>Vehicle Registration No.</label>
                                    <input type=" text" class="form-control @error('reg_no') is-invalid @enderror" name='reg_no' value="{{$aRow && isset(json_decode($aRow->asset_json)->reg_no)?json_decode($aRow->asset_json)->reg_no:old('reg_no') }}" placeholder="Enter Vehicle Registration No.">
                                    @error('reg_no')
                                        <label class="col-form-label" for="inputError"><i class="fa fa-times-circle text-danger "></i>&nbsp;&nbsp;{{ $message }}</label>
                                    @enderror
                                </div>
                                <div class="form-group col-lg-6">
                                    <label>Chesis No.</label>
                                    <input type=" text" class="form-control @error('chesis_no') is-invalid @enderror" name='chesis_no' value="{{$aRow && isset(json_decode($aRow->asset_json)->chesis_no)?json_decode($aRow->asset_json)->chesis_no:old('chesis_no') }}" placeholder="Enter Chesis No.">
                                    @error('chesis_no')
                                        <label class="col-form-label" for="inputError"><i class="fa fa-times-circle text-danger "></i>&nbsp;&nbsp;{{ $message }}</label>
                                    @enderror
                                </div>
                                <div class="form-group col-lg-6">
                                    <label>Insurance policy No</label>
                                    <input type=" text" class="form-control @error('policy_no') is-invalid @enderror" name='policy_no' value="{{ $aRow && isset(json_decode($aRow->asset_json)->policy_no)?json_decode($aRow->asset_json)->policy_no:old('policy_no') }}" placeholder="Enter Insurance policy No">
                                    @error('policy_no')
                                        <label class="col-form-label" for="inputError"><i class="fa fa-times-circle text-danger "></i>&nbsp;&nbsp;{{ $message }}</label>
                                    @enderror
                                </div>
                                <div class="form-group col-lg-6">
                                    <label>Renewal Date</label>
                                    <input type=" date" class="form-control @error('renewal_date') is-invalid @enderror" name='renewal_date' value="{{ $aRow && isset(json_decode($aRow->asset_json)->renewal_date)?json_decode($aRow->asset_json)->renewal_date:old('renewal_date') }}" placeholder="Enter Renewal Date">
                                    @error('renewal_date')
                                        <label class="col-form-label" for="inputError"><i class="fa fa-times-circle text-danger "></i>&nbsp;&nbsp;{{ $message }}</label>
                                    @enderror
                                </div>
                                <div class="form-group col-lg-6">
                                    <label>Insurance Company</label>
                                    <input type=" text" class="form-control @error('insurance_company') is-invalid @enderror" name='insurance_company' value="{{ $aRow && isset(json_decode($aRow->asset_json)->insurance_company)?json_decode($aRow->asset_json)->insurance_company:old('insurance_company') }}" placeholder="Enter Insurance Company">
                                    @error('insurance_company')
                                        <label class="col-form-label" for="inputError"><i class="fa fa-times-circle text-danger "></i>&nbsp;&nbsp;{{ $message }}</label>
                                    @enderror
                                </div>
                                <div class="form-group col-lg-6">
                                    <label>Sum Insurred</label>
                                    <input type=" text" class="form-control @error('sum_insurred') is-invalid @enderror" name='sum_insurred' value="{{ $aRow && isset(json_decode($aRow->asset_json)->sum_insurred)?json_decode($aRow->asset_json)->sum_insurred:old('sum_insurred') }}" placeholder="Sum Insurred">
                                    @error('sum_insurred')
                                        <label class="col-form-label" for="inputError"><i class="fa fa-times-circle text-danger "></i>&nbsp;&nbsp;{{ $message }}</label>
                                    @enderror
                                </div>
                                <div class="form-group col-lg-6">
                                    <label>Premium</label>
                                    <input type=" text" class="form-control @error('premium') is-invalid @enderror" name='premium' value="{{ $aRow && isset(json_decode($aRow->asset_json)->premium)?json_decode($aRow->asset_json)->premium:old('premium') }}" placeholder="Enter Premium">
                                    @error('sum_insurred')
                                        <label class="col-form-label" for="inputError"><i class="fa fa-times-circle text-danger "></i>&nbsp;&nbsp;{{ $message }}</label>
                                    @enderror
                                </div>
                                <div class="form-group col-lg-6">
                                    <label>Polution (PUC) valid  upto </label>
                                    <input type="date" class="form-control @error('polution_valid_upto') is-invalid @enderror" name='polution_valid_upto' value="{{ $aRow && isset(json_decode($aRow->asset_json)->polution_valid_upto)?json_decode($aRow->asset_json)->polution_valid_upto:old('polution_valid_upto') }}" placeholder="Enter PUC Validity">
                                    @error('polution_valid_upto')
                                        <label class="col-form-label" for="inputError"><i class="fa fa-times-circle text-danger "></i>&nbsp;&nbsp;{{ $message }}</label>
                                    @enderror
                                </div>
                                <div class="form-group col-lg-6">
                                    <label>Renewal Date</label>
                                    <input type="date" class="form-control @error('renewal_date') is-invalid @enderror" name='renewal_date' value="{{ $aRow && isset(json_decode($aRow->asset_json)->renewal_date)?json_decode($aRow->asset_json)->renewal_date:old('renewal_date') }}" placeholder="Enter PUC Validity">
                                    @error('renewal_date')
                                        <label class="col-form-label" for="inputError"><i class="fa fa-times-circle text-danger "></i>&nbsp;&nbsp;{{ $message }}</label>
                                    @enderror
                                </div>

                            </div>
                            <div class="form-group col-lg-6">
                                <label>Manufacturer</label>
                                <input type=" text" class="form-control @error('make') is-invalid @enderror" name='make' value="{{ $aRow && isset(json_decode($aRow->asset_json)->make)?json_decode($aRow->asset_json)->make:old('make') }}" placeholder="Asset Manufacturer">
                                @error('make')
                                    <label class="col-form-label" for="inputError"><i class="fa fa-times-circle text-danger "></i>&nbsp;&nbsp;{{ $message }}</label>
                                @enderror
                            </div>
                            <div class="form-group col-lg-6">
                                <label>Model</label>
                                <input type=" text" class="form-control @error('model') is-invalid @enderror" name='model' value="{{ $aRow && isset(json_decode($aRow->asset_json)->model)?json_decode($aRow->asset_json)->model:old('model') }}" placeholder="Asset Model">
                                @error('model')
                                    <label class="col-form-label" for="inputError"><i class="fa fa-times-circle text-danger "></i>&nbsp;&nbsp;{{ $message }}</label>
                                @enderror
                            </div>
                            <div class="form-group col-lg-6">
                                <label>Capacity</label>
                                <input type=" text" class="form-control @error('capacity') is-invalid @enderror" name='capacity' value="{{ $aRow && isset(json_decode($aRow->asset_json)->capacity)?json_decode($aRow->asset_json)->capacity:old('capacity') }}" placeholder="Asset Capacity">
                                @error('capacity')
                                    <label class="col-form-label" for="inputError"><i class="fa fa-times-circle text-danger "></i>&nbsp;&nbsp;{{ $message }}</label>
                                @enderror
                            </div>
                            <div class="form-group col-lg-6">
                                <label>Year of MFG</label>
                                <input type="date" class="form-control" placeholder="Select date" name="year_of_mfg" value="{{ $aRow && isset(json_decode($aRow->asset_json)->year_of_mfg)?json_decode($aRow->asset_json)->year_of_mfg:old('year_of_mfg') }}">
                                @error('year_of_mfg')
                                    <label class="col-form-label" for="inputError"><i class="fa fa-times-circle text-danger "></i>&nbsp;&nbsp;{{ $message }}</label>
                                @enderror
                            </div>
                            <div class="form-group col-lg-6">
                                <label>Year of Purchase/Installation</label>
                                <input type="date" class="form-control" placeholder="Select date" name="year_of_purchase" value="{{ $aRow && isset(json_decode($aRow->asset_json)->year_of_purchase)?json_decode($aRow->asset_json)->year_of_purchase:old('year_of_purchase') }}">
                                @error('year_of_purchase')
                                    <label class="col-form-label" for="inputError"><i class="fa fa-times-circle text-danger "></i>&nbsp;&nbsp;{{ $message }}</label>
                                @enderror
                            </div>
                            <div class="form-group col-lg-6">
                                <label>Working Condition</label>
                                <select name="working_condition" class="form-control @error('working_condition') is-invalid @enderror" id="working_condition">
                                    <option value="Working"  <?php echo $aRow && (isset(json_decode($aRow->asset_json)->working_condition) && json_decode($aRow->asset_json)->working_condition=="Working")?'selected':'' ?>>Working</option>
                                    <option value="Non-working" <?php echo $aRow && (isset(json_decode($aRow->asset_json)->working_condition) && json_decode($aRow->asset_json)->working_condition=="Non-working")?'selected':'' ?>>Non-working</option>
                                    <option value="Discarded" <?php echo $aRow && (isset(json_decode($aRow->asset_json)->working_condition) && json_decode($aRow->asset_json)->working_condition=="Discarded")?'selected':'' ?>>Discarded</option>
                                    <option value="sold off" <?php echo $aRow && (isset(json_decode($aRow->asset_json)->working_condition) && json_decode($aRow->asset_json)->working_condition=="sold off")?'selected':'' ?>>Sold off</option>
                                    <option value="Transferred" <?php echo $aRow && (isset(json_decode($aRow->asset_json)->working_condition) && json_decode($aRow->asset_json)->working_condition=="Transferred")?'selected':'' ?>>Transferred</option>
                                </select>
                                @error('working_condition')
                                    <label class="col-form-label" for="inputError"><i class="fa fa-times-circle text-danger "></i>&nbsp;&nbsp;{{ $message }}</label>
                                @enderror
                            </div>

                            <div class="form-group col-lg-6">
                                <label>Name</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" name='name' value="{{ $aRow && isset(json_decode($aRow->asset_json)->name)?json_decode($aRow->asset_json)->name:old('name') }}" placeholder="Name">
                                @error('name')
                                    <label class="col-form-label" for="inputError"><i class="fa fa-times-circle text-danger "></i>&nbsp;&nbsp;{{ $message }}</label>
                                @enderror
                            </div>
                            <div class="form-group col-lg-6">
                                <label>Ref No.</label>
                                <input type="text" class="form-control @error('ref_no') is-invalid @enderror" name='ref_no'  placeholder="Ref No." value="{{ $aRow && isset(json_decode($aRow->asset_json)->ref_no)?json_decode($aRow->asset_json)->ref_no:old('ref_no') }}">
                                @error('ref_no')
                                    <label class="col-form-label" for="inputError"><i class="fa fa-times-circle text-danger "></i>&nbsp;&nbsp;{{ $message }}</label>
                                @enderror
                            </div>
                            <div class="form-group col-lg-6">
                                <label>Allocated to</label>
                                <input type="text" class="form-control @error('allocated_to') is-invalid @enderror" name='allocated_to' value="{{$aRow && isset(json_decode($aRow->asset_json)->allocated_to)?json_decode($aRow->asset_json)->allocated_to:old('allocated_to') }}" placeholder="Allocated to">
                                @error('allocated_to')
                                    <label class="col-form-label" for="inputError"><i class="fa fa-times-circle text-danger "></i>&nbsp;&nbsp;{{ $message }}</label>
                                @enderror
                            </div>
                            <div class="form-group col-lg-6">
                                <label>Re-located to</label>
                                <input type="text" class="form-control @error('re_located_to') is-invalid @enderror" name='re_located_to' value="{{ $aRow && isset(json_decode($aRow->asset_json)->re_located_to)?json_decode($aRow->asset_json)->re_located_to:old('re_located_to') }}" placeholder="Re-located to">
                                @error('re_located_to')
                                    <label class="col-form-label" for="inputError"><i class="fa fa-times-circle text-danger "></i>&nbsp;&nbsp;{{ $message }}</label>
                                @enderror
                            </div>
                            <div class="form-group col-lg-12">
                                <label>Remark</label>

                                <textarea class="form-control @error('remarks') is-invalid @enderror" name="remarks" id="remarks" rows="3">{{ $aRow && isset(json_decode($aRow->asset_json)->remarks)?json_decode($aRow->asset_json)->remarks:old('remarks') }}</textarea>
                                @error('remarks')
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


