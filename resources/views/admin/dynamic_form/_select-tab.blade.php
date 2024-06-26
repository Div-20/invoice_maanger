@php
$input_form_name = 'input_array';
$collapse_toggle = 'toggle_id_string_demo6';
if(isset($clone_option_counter)){
    $collapse_toggle = 'toggle_id_string'.$clone_option_counter;
    $input_form_name = 'input_array_'.$clone_option_counter;
}
$clone_counter = isset($clone_counter) ? $clone_counter : 600;
@endphp
<div class="input-content">
    <div class="d-flex w-100 justify-content-between dynamic-form-heading">
        <a href="#{{$collapse_toggle}}" class="info-box-text text-muted dynamic-collapse-target" data-toggle="collapse">
            <i class="fa fa-caret-down mr-2" aria-hidden="true"></i><span class="">{{$dynamic_form_obj::$input_type_labels[$dynamic_form_obj::TYPE_SELECT]}}</span>
        </a>
        <div><button type="button"  data-parent="li"  class="btn btn-sm btn-danger remove-clone-btn">Remove</button></div>
    </div>
    <div id="{{$collapse_toggle}}" class="collapse-panel-box collapse dynamic-collapse-target">
        <input type="hidden" class="form-control change_input_index" name="form_data[{{$input_form_name}}][input_type]" value="{{$dynamic_form_obj::TYPE_SELECT}}">
        <div class="form-group">
            <label>Enter label Name <span class="text-danger bold">*</span></label>
            <input type="text" class="form-control change_input_index"  value="{{$input_data['label'] ?? ''}}" name="form_data[{{$input_form_name}}][label]" placeholder="Enter label Name">
        </div>
        <div class="form-group">
            <label>Enter Note for label</label>
            <input type="text" class="form-control change_input_index" value="{{$input_data['note'] ?? ''}}" name="form_data[{{$input_form_name}}][note]" placeholder="Enter Note for label">
        </div>
        <div class="form-group">
            <label>Add Default Selected <br><span class="text-danger">(Note: Option value to save and default value should be same)</,span></label>
            <input type="text" class="form-control change_input_index"  value="{{$input_data['default'] ?? ''}}" name="form_data[{{$input_form_name}}][default]" placeholder="Enter Default">
        </div>
        <div class="form-group clearfix">
            <label>Make this Filed Required</label><br>
            <div class="icheck-primary d-inline update_unique_ids ">
                <input type="checkbox" id="check_box_{{$clone_counter}}" class="change_input_index" @if (isset($input_data['required']) && $input_data['required']) checked @endif name="form_data[{{$input_form_name}}][required]">
                <label for="check_box_{{$clone_counter}}"> Is Required filed</label>
            </div>
        </div>
        @php ++$clone_counter;@endphp
        <div class="form-group clearfix">
            <label>Make this Filed disabled</label><br>
            <div class="icheck-primary d-inline update_unique_ids ">
                <input type="checkbox" id="check_box_{{$clone_counter}}" class="change_input_index" @if (isset($input_data['disabled']) && $input_data['disabled']) checked @endif name="form_data[{{$input_form_name}}][disabled]">
                <label for="check_box_{{$clone_counter}}"> Is disabled</label>
            </div>
        </div>
        @php ++$clone_counter;@endphp
        <div class="form-group clearfix">
            <label>Multiple Select</label><br>
            <div class="icheck-primary d-inline update_unique_ids ">
                <input type="checkbox" id="check_box_{{$clone_counter}}" class="change_input_index" @if (isset($input_data['multiple']) && $input_data['multiple']) checked @endif name="form_data[{{$input_form_name}}][multiple]">
                <label for="check_box_{{$clone_counter}}"> User can select multiple option</label>
            </div>
        </div>
        <div class="form-group clearfix parent-option-div">
            <div class="card">
                <div class="card-header bg-primary">
                    <div class="justify-content-between d-flex p-0">
                        <label class="float-left p-0">Add More Options</label>
                        <button type="button" class="btn btn-success btn-sm add-clone-btn">Add</button>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <ul class="p-0 child-append-section">
                    @if (isset($input_data['options']) && $input_data['options'])
                    @foreach ($input_data['options'] as $checkbox_options_key => $checkbox_options_value)
                    <li class="sortable-disabled">
                        <div class="card" >
                            <div class="card-header">
                                <div class="justify-content-between d-flex">
                                    <h5 class="m-0">Dropdown Options</h5><button type="button" data-parent=".sortable-disabled" class="btn btn-danger btn-sm remove-clone-btn">Remove</button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend"><span class="input-group-text bg-info">Value to Show</span></div>
                                    <input type="text" class="form-control change_input_index" value="{{$checkbox_options_value}}" name="form_data[{{$input_form_name}}][options][title][]">
                                </div>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend"><span class="input-group-text bg-info">Value to Save</span></div>
                                    <input type="text" class="form-control change_input_index" value="{{$checkbox_options_key}}" name="form_data[{{$input_form_name}}][options][value][]">
                                </div>                
                            </div>
                        </div>
                    </li>
                    @endforeach
                    @else
                    <li class="sortable-disabled">
                        <div class="card" >
                            <div class="card-header">
                                <div class="justify-content-between d-flex">
                                    <h5 class="m-0">Dropdown Options</h5><button type="button" data-parent=".sortable-disabled" class="btn btn-danger btn-sm remove-clone-btn">Remove</button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend"><span class="input-group-text bg-info">Value to Show</span></div>
                                    <input type="text" class="form-control change_input_index" name="form_data[{{$input_form_name}}][options][title][]">
                                </div>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend"><span class="input-group-text bg-info">Value to Save</span></div>
                                    <input type="text" class="form-control change_input_index" name="form_data[{{$input_form_name}}][options][value][]">
                                </div>                
                            </div>
                        </div>
                    </li>
                    @endif

                </ul>
            </div>
        </div>
    </div>
</div>
