<?PHP 
    $grid = (isset($grid)) ? $grid : 'col-sm-4';
?>
<div class="row mx-0">
  <div class="{{$grid}}">
    <div class="form-group">
      <label>Meta Title</label>
        <input type=" text" class="form-control @error('meta_title') is-invalid @enderror" name='meta_title' value="{{ $aRow->meta_title ?? old('meta_title')}}" placeholder="Enter Service Meta Title">
      @error('meta_title')
      <label class="col-form-label" for="inputError"><i class="fa fa-times-circle text-danger "></i>&nbsp;&nbsp;{{ $message }}</label>
      @enderror
    </div>
  </div>
  <div class="{{$grid}}">
    <div class="form-group">
      <label>Meta Keywords</label>
        <input type="text" class="form-control @error('meta_keywords') is-invalid @enderror select2jsTagInput" name='meta_keywords' multiple value="{{ $aRow->meta_keywords ?? old('meta_keywords')}}" data-role="select2jsTagInput" placeholder="Enter Meta Keywords">
        <label class="text-danger"><b>Note:</b>Make value (,) saprated </label>
      @error('meta_keywords')
      <label class="col-form-label" for="inputError"><i class="fa fa-times-circle text-danger "></i>&nbsp;&nbsp;{{ $message }}</label>
      @enderror
    </div>
  </div>
  <div class="{{$grid}}">
    <div class="form-group">
      <label>Meta Description</label>
        <textarea class="form-control @error('meta_description') is-invalid @enderror" rows="3" id="getEditor1" name="meta_description"  placeholder="Enter Meta Description ">{{ $aRow->meta_description ?? old('meta_description')}}</textarea>
      @error('meta_description')
      <label class="col-form-label" for="inputError"><i class="fa fa-times-circle text-danger "></i>&nbsp;&nbsp;{{ $message }}</label>
      @enderror
    </div>
  </div>
</div>{{-- end row --}}
