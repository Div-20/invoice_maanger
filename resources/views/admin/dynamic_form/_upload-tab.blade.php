@php
$input_form_name = 'input_array';
$collapse_toggle = 'toggle_id_string_demo8';
if(isset($clone_option_counter)){
    $collapse_toggle = 'toggle_id_string'.$clone_option_counter;
    $input_form_name = 'input_array_'.$clone_option_counter;
}
$clone_counter = isset($clone_counter) ? $clone_counter : 800;
@endphp
<div class="input-content">
    <div class="d-flex w-100 justify-content-between dynamic-form-heading">
        <a href="#{{$collapse_toggle}}" class="info-box-text text-muted dynamic-collapse-target" data-toggle="collapse">
            <i class="fa fa-caret-down mr-2" aria-hidden="true"></i><span class="">{{$dynamic_form_obj::$input_type_labels[$dynamic_form_obj::TYPE_FILE]}}</span>
        </a>
        <div><button type="button"  data-parent="li"  class="btn btn-sm btn-danger remove-clone-btn">Remove</button></div>
    </div>
    <div id="{{$collapse_toggle}}" class="collapse-panel-box collapse dynamic-collapse-target">
        <input type="hidden" class="form-control change_input_index" name="form_data[{{$input_form_name}}][input_type]" value="{{$dynamic_form_obj::TYPE_FILE}}">
        <div class="form-group">
            <label>Enter label Name <span class="text-danger bold">*</span></label>
            <input type="text" class="form-control change_input_index"  value="{{$input_data['label'] ?? ''}}" name="form_data[{{$input_form_name}}][label]" placeholder="Enter label Name">
        </div>
        <div class="form-group">
            <label>Enter Note for label</label>
            <input type="text" class="form-control change_input_index" value="{{$input_data['note'] ?? ''}}" name="form_data[{{$input_form_name}}][note]" placeholder="Enter Note for label">
        </div>
        <div class="form-group clearfix">
            <label>Make this Filed Required</label><br>
            <div class="icheck-primary d-inline update_unique_ids ">
                <input type="checkbox" class="change_input_index" id="check_box_{{$clone_counter}}" @if (isset($input_data['required']) && $input_data['required']) checked @endif name="form_data[{{$input_form_name}}][required]">
                <label for="check_box_{{$clone_counter}}"> Is Required filed</label>
            </div>
        </div>
        @php ++$clone_counter;@endphp
        <div class="form-group clearfix">
            <label>Select Multiple File</label><br>
            <div class="icheck-primary d-inline update_unique_ids ">
                <input type="checkbox" class="change_input_index" id="check_box_{{$clone_counter}}" @if (isset($input_data['multiple']) && $input_data['multiple']) checked @endif name="form_data[{{$input_form_name}}][multiple]">
                <label for="check_box_{{$clone_counter}}"> User can select multiple files</label>
            </div>
        </div>
        @php ++$clone_counter;@endphp
        <div class="form-group clearfix">
            <label>Make this Filed disabled</label><br>
            <div class="icheck-primary d-inline update_unique_ids ">
                <input type="checkbox" class="change_input_index" id="check_box_{{$clone_counter}}" @if (isset($input_data['disabled']) && $input_data['disabled']) checked @endif name="form_data[{{$input_form_name}}][disabled]">
                <label for="check_box_{{$clone_counter}}"> Is disabled</label>
            </div>
        </div>
    </div>
</div>