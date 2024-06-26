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
            <form  action="{{route('admin.update.location')}}" onsubmit="return submitFrm(this)" id='countryForm' >
            @method('patch')
            {{ csrf_field() }}
            {!! Form::hidden('id', $aRow->id) !!}
            {!! Form::hidden('type', $type) !!}
    
            @if(isset($country) && $country)
            <div class="form-group @error('country_id') has-error @enderror">
                <label>Select Country</label>
                {!! Form::select('country_id', ['' => '---Select Country---'] + ($country ?? array()), $aRow->country_id ?? old('country_id'), ['required'=>'required','class'=>'form-control ajaxCall' , "data-target"=>'city','data-action'=>route('getCity') ]) !!}
            </div>
            @endif

            @if(isset($state) && $state)
            <div class="form-group @error('state_id') has-error @enderror">
                <label>Select State</label>
                {!! Form::select('state_id', ['' => '---Select State---'] + ($state ?? array()), $aRow->state_id ?? old('state_id'), ['required'=>'required','class'=>'form-control ajaxCall' , "data-target"=>'city','data-action'=>route('getCity') ]) !!}
            </div>
            @endif
            
            @if ($type == 'city')
            <div class="form-group">
                <label>Select District</label>
                {!! Form::hidden('state_id', $aRow->state_id) !!}
                {!! Form::select('district_id', ['' => '---Select District---'] + ($district ?? array()), $aRow->district_id ?? old('district_id'), ['class'=>'form-control' , "id" => 'district' ]) !!}
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
            <div class="form-group @error('city_id') has-error @enderror">
                <label>Select City</label>
                {!! Form::select('city_id', ['' => '---Select City---'] + ($city ?? array()), $aRow->city_id ?? old('city_id'), ['required'=>'required','id'=>'city','class'=>'form-control']) !!}
            </div>
            @endif        
            <div class="form-group @error('name') has-error @enderror">
                <label>Enter Name</label>
                <input type=" text" class="form-control" name='name' value="{{ $aRow->name ?? old('name')}}" placeholder="Enter Full Name"> 
            </div>

            @if ($type == 'country')
            <div class="form-group @error('code') has-error @enderror">
                <label>Enter Country code (Eg. +91)</label>
                <input type="text" class="form-control" name='code' value="{{ $aRow->code ?? old('code')}}" placeholder="Enter Country code"> 
            </div>
            <div class="form-group @error('currency') has-error @enderror">
                <label>Enter Country Currency code (Eg. INR) (Only String)</label>
                <input type="text" class="form-control" name='currency' value="{{ $aRow->currency ?? old('currency')}}" placeholder="Enter Country Currency Code"> 
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
                <button type="submit" class="btn btn-info pull-right">Submit</button>
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