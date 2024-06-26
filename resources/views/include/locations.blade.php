<?php $grid = isset($grid) ? $grid : 'col-sm-4'; ?>
<div class="row mx-0">
    <div class="{{ $grid }}">
        <div class="form-group">
            <label>Select State</label>
            {!! Form::select('state', ['' => '---Select State---'] + ($state ?? []), $aRow->state ?? old('state'), [ 'class' => (($errors->has('state')) ? 'is-invalid' : '') . " form-control ajaxCall select2jsSearch", 'data-target' => 'city', 'data-action' => route('getCity'), ]) !!}
            @error('state')
                <label class="col-form-label" for="inputError"><i class="fa fa-times-circle text-danger "></i>&nbsp;&nbsp;{{ $message }}</label>
            @enderror
        </div>
    </div>
    <div class="{{ $grid }}">
        <div class="form-group">
            <label>Select City</label>
            {!! Form::select('city', ['' => '---Select City---'] + ($city ?? []), $aRow->city ?? old('city'), [ 'id' => 'city', 'class' => (($errors->has('city')) ? 'is-invalid' : '') . " form-control  ajaxCall select2jsSearch", 'data-target' => 'area', 'data-action' => route('getArea'), ]) !!}
            @error('city')
                <label class="col-form-label" for="inputError"><i class="fa fa-times-circle text-danger "></i>&nbsp;&nbsp;{{ $message }}</label>
            @enderror
        </div>
    </div>

    @if (isset($getarea) && $getarea)
        <div class="{{ $grid }}">
            <div class="form-group">
                <label>Select Area</label>
                {!! Form::select('area', ['' => '---Select Area---'] + ($area ?? []), $aRow->area ?? old('area'), [ 'id' => 'area', 'class' => (($errors->has('area')) ? 'is-invalid' : '') . " form-control select2-tags", ]) !!}
                @error('area')
                    <label class="col-form-label" for="inputError"><i class="fa fa-times-circle text-danger "></i>&nbsp;&nbsp;{{ $message }}</label>
                @enderror
            </div>
        </div>
    @endif


</div>
