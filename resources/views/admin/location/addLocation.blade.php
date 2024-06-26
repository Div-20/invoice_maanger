<div class="modal-header p-0">
    <h4 class="modal-title">Manage {{$type}}</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">×</span>
    </button>
</div>
<div class="py-3">
    <div class="row">
    <div class="col-sm-12">
        <div class="box-body">
        <form  action="{!! action('App\Http\Controllers\AdminControllers\LocationController@store') !!}" method="post" onsubmit="return submitFrm(this)" id='countryForm' >
            {{ csrf_field() }}

        @if(isset($country) && $country)
        <div class="form-group @error('country') has-error @enderror">
            <label>Select Country</label>
            {!! Form::select('country_id', ['' => '---Select Country---'] + ($country ?? array()), $aRow->country ?? old('country'), ['required'=>'required','class'=>'form-control ajaxCall' , "data-target"=>'city','data-action'=>route('getCity') ]) !!}
        </div>
        @endif

        @if(isset($state) && $state)
        <div class="form-group @error('state') has-error @enderror">
            <label>Select State</label>
            {!! Form::select('state_id', ['' => '---Select State---'] + ($state ?? array()), $aRow->state ?? old('state'), ['required'=>'required','class'=>'form-control ajaxCall' , "data-target"=>'city','data-action'=>route('getCity') ]) !!}
        </div>
        @endif

        @if ($type == 'city')
        <div class="form-group">
            {!! Form::hidden('state_id', $id) !!}
            <label>Select District</label>
            {!! Form::select('district_id', ['' => '---Select State---'] + ($district ?? array()), $aRow->district_id ?? old('district_id'), ['class'=>'form-control' ]) !!}
        </div>
        <div class="form-group">
            <label>Select Tier type</label>
            {!! Form::select('tier_type',($tier_type ?? array()), $aRow->tier_type ?? 3, ['class'=>'form-control' ]) !!}
        </div>
        <div class="form-group">
            <label>Enter Valid Pin Code</label>
            {!! Form::input('text' , 'pin_code',  $aRow->pin_code ?? old('pin_code'), ['class'=>'form-control' ]) !!}
        </div>
        @endif


        @if(isset($city) && $city)
        <div class="form-group @error('city') has-error @enderror">
            <label>Select City</label>
            {!! Form::select('city_id', ['' => '---Select City---'] + ($city ?? array()), $aRow->city ?? old('city'), ['required'=>'required','id'=>'city','class'=>'form-control']) !!}
        </div>
        @endif        

        <div class="form-group @error('name') has-error @enderror">
            <label>Enter Name</label>
            {!! Form::hidden('type', $type) !!}
            <input type=" text" class="form-control" name='name' value="{{ $aRows->name ?? old('name')}}" placeholder="Enter Full Name"> 
        </div>
        
        @if ($type == 'country')
        <div class="form-group @error('code') has-error @enderror">
            <label>Enter Country code (Eg. +91)</label>
            <input type="text" class="form-control" name='code' value="{{ $aRows->code ?? old('code')}}" placeholder="Enter Country code"> 
        </div>
        <div class="form-group @error('currency') has-error @enderror">
            <label>Enter Country Currency code (Eg. INR) (Only String)</label>
            <input type="text" class="form-control" name='currency' value="{{ $aRows->currency ?? old('currency')}}" placeholder="Enter Country Currency Code"> 
        </div>
        @endif        


        @if ($type == 'city')
        @php
            $multiple_second = true;
            $fileName = 'icon';
            $labelText = 'Upload Icon';
            $customPath = 'uploads/locations/';
        @endphp
        @include('include.uploadimage')            
        @endif

        <div class="box-footer intrfacr">
            <button type="submit" class="btn btn-info text-white pull-right">Submit</button>
        </div>
        {!! Form::close() !!}
        </div>
    </div> {{-- box-body  --}}
    </div> {{-- First col end --}}
</div>
<script>
    $(".ajaxCall").on('change', function (e) {
        e.preventDefault();
        fetchData(this);
    });
</script>