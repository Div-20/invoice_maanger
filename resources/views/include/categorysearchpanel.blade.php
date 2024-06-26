<form method="get" action="" class=""> 
	<div class="row mx-0"><h4 class="col-md-12">Filter:</h4></div>
	<div class="row mx-0">

    <div class="col-sm-4">
      <div class="form-group">
        <label>Category Name</label>
        <input type="text" name="requestData" id="" value="{{$aQuery['requestData'] ?? old('requestData')}}" class="form-control" placeholder="Enter search request">
      </div>
    </div>

    @if (isset($getcategory) && $getcategory)
    <div class="col-sm-3">
        <div class="form-group">
          <label>Select Category</label>
          {!! Form::select('category_id', ['' => '---Select Category---'] + $category, $aQuery['category_id'] ?? old('category_id'), ['class'=>'form-control ajaxCall' ,'data-target' => 'services','id'=>'category' ,'data-action'=>route('getService') ]) !!}
        </div>
    </div>
    @endif
    @if (isset($getservices) && $getservices)
    <div class="col-sm-3">
        <div class="form-group">
          <label>Select Service</label>
          {!! Form::select('service_id', ['' => '---Select Service---'] + $services, $aQuery['service_id'] ?? old('service_id'), ['class'=>'form-control ' ,'id' => 'services' ]) !!}
        </div>
    </div>
    @endif

    <div class="col-md-2">
        <div class="form-group">
            <label class="d-block" style="visibility: hidden" >Select Service</label>
            <button type="submit" class="btn btn-raised btn-primary btn-round">Search</button>
            <a href="{{Request::url()}}">
                <button type="button" class="btn btn-raised btn-info btn-round">Reset</button>
            </a>
        </div>
    </div>

  </div>
</form>

