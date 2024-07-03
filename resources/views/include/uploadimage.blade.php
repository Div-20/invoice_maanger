@php $customPath = $customPath ?? 'uploads/' ; @endphp
@php $fileName = isset($fileName) ? $fileName : 'image'; @endphp
@php $labelText = isset($labelText) ? $labelText : 'Upload Image'; @endphp

@if (isset($single_one) && $single_one)
@php $fileName = isset($fileName) ? $fileName : 'image'; @endphp
<div class="form-group ">
{!! HTML::image( asset($customPath.($aRow->$fileName ?? '' )) , '' , array('class'=>['my-2','w-50','img-responsive','mx-auto'], 'height'=>'100','id'=>'upload'.$fileName.'target')) !!}
</div>
<div class="form-group @error($fileName) has-error @enderror">
    <label>Upload {{$labelText}}</label>
    <input type="file" class="upload-single form-control" data-type="excel" name="{{$fileName}}" data-error="#img-{{$fileName}}-Error" data-id="#upload{{$fileName}}target">
    @error($fileName)
    <label class="col-form-label" for="inputError"><i class="fa fa-times-circle text-danger "></i>&nbsp;&nbsp;{{ $message }}</label>
    @enderror
    <div id="img-{{$fileName}}-Error"></div>
</div>
@endif

@if (isset($single_doc) && $single_doc)
<div class="form-group @error($fileName) has-error @enderror">
    <label>Upload {{$labelText}}</label>
    <input type="file" class="upload-single w-100 p-1 form-control" data-type="excel" name="{{$fileName}}" data-error="#img-{{$fileName}}-Error" data-id="#upload{{$fileName}}target">
    @error($fileName)
    <label class="col-form-label" for="inputError"><i class="fa fa-times-circle text-danger "></i>&nbsp;&nbsp;{{ $message }}</label>
    @enderror
    <div id="img-{{$fileName}}-Error"></div>
</div>
@endif

@if (isset($single_second) && $single_second)
<div class="form-group">
{!! HTML::image( asset($customPath.($aRow->$fileName ?? '' )) , '' , array('class'=>['my-2','w-50','img-responsive','mx-auto'], 'height'=>'100','id'=>'upload'.$fileName.'target')) !!}
</div>
<div class="form-group @error($fileName) has-error @enderror">
    <label for="upload_image" class="upload_image_label">{{$labelText}}</label>
    <input type="file" id="upload_image" class="d-none upload-single form-control" data-type="image" name="{{$fileName}}" data-error="#imgError" data-id="#upload{{$fileName}}target">
    @error($fileName)
    <label class="col-form-label" for="inputError"><i class="fa fa-times-circle text-danger "></i>&nbsp;&nbsp;{{ $message }}</label>
    @enderror
    <div id="imgError"></div>
</div>
@endif


@if (isset($multiple_one) && $multiple_one)

{!! HTML::image( asset($customPath.($aRow->$fileName ?? '' )) , '' , array('class'=>['my-2','w-50','img-responsive','mx-auto'], 'height'=>'100','id'=>'upload'.$fileName.'target')) !!}
<div class="form-group @error($fileName) has-error @enderror">
    <label>Upload {{$fileName}}</label>
    <input type="file" class="upload-single form-control" data-type="image" name="{{$fileName}}[]" data-error="#img-{{$fileName}}-Error" data-id="#upload{{$fileName}}target">
    @error($fileName)
    <label class="col-form-label" for="inputError"><i class="fa fa-times-circle text-danger "></i>&nbsp;&nbsp;{{ $message }}</label>
    @enderror
    <div id="img-{{$fileName}}-Error"></div>
</div>
@endif

@if (isset($multiple_second) && $multiple_second)
{!! HTML::image( asset($customPath.($aRow->$fileName ?? '' )) , '' , array('class'=>['my-2','w-50','img-responsive','mx-auto'], 'height'=>'100','id'=>'upload'.$fileName.'target')) !!}
<div class="form-group @error($fileName) has-error @enderror">
    <label for="upload_image" class="upload_image_label">{{$labelText}}</label>
    <input type="file" id="upload_image" class="d-none upload-single form-control" data-type="image" name="{{$fileName}}[]" data-error="#imgError" data-id="#upload{{$fileName}}target">
    @error($fileName)
    <label class="col-form-label" for="inputError"><i class="fa fa-times-circle text-danger "></i>&nbsp;&nbsp;{{ $message }}</label>
    @enderror
    <div id="imgError"></div>
</div>
@endif


@if (isset($multiOne) && $multiOne)
<div id="productImg">
    @if(!empty($aRow->image))
    @php $imgArray = explode(',',$aRow->image) @endphp
    @foreach ($imgArray as $item)
    {!! HTML::image( asset($customPath.$item) , '' , array('class'=>['my-2'], 'height'=>'100')) !!}
    @endforeach
    @endif
</div>
{{-- <div id="preview"></div> --}}
<div class="form-group @error('image') has-error @enderror">
    <label>Upload Image</label>
    <input type="file" class="form-control upload-multi" name="image[]" multiple>
    @error('image')
    <label class="col-form-label" for="inputError"><i class="fa fa-times-circle text-danger "></i>&nbsp;&nbsp;{{ $message }}</label>
    @enderror
</div>
@endif




@if (isset($multiSec) && $multiSec)
<div id="productImg">
    @if(!empty($aRow->image))
    @php $imgArray = explode(',',$aRow->image) @endphp
    @foreach ($imgArray as $item)
    {!! HTML::image( asset($customPath.$item) , '' , array('class'=>['my-2'], 'height'=>'100')) !!}
    @endforeach
    @endif
</div>
<div class="form-group @error('image') has-error @enderror">
    <label>Upload Image</label>
    <div class="sections">
        <div class="images" id="uploadImage">
            <div class="pic">
                add
            </div>
        </div>
    </div>
    @error('image')
    <label class="col-form-label" for="inputError"><i class="fa fa-times-circle text-danger "></i>&nbsp;&nbsp;{{ $message }}</label>
    @enderror
</div>
@endif
