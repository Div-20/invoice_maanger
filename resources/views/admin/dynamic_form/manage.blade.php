@extends('admin.layout.admin-layout')
@inject('helperObj', 'App\Helpers\CustomHelper')
@php
    $page_title = "Order Dynamic Form";
    $aAuth = \Auth::guard('admin')->user();
@endphp
@section('title')
    {{ $page_title }}
@endsection
@section('nav-manu-content')
    <li class="nav-item d-none d-sm-inline-block">
        <a href="{{ route('admin.dashboard') }}" class="nav-link">Dashboard</a>
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
            <div class="container-fluid" id="master-parent">                
                <div class="row">
                    <div class="col-sm-6">
                        <div class="card">
                            <div class="card-header bg-primary">
                                <h3 class="m-0">Drag and drop in form</h3>
                            </div>
                            <div class="card-body">
                                <ul class="p-0">

                                    {{-- text filed --}}
                                    <li class="ui-state-highlight draggable w-100 h-auto">
                                        <div class="info-box bg-light">
                                            <div class="info-box-content">
                                                <div class="dummy-content">
                                                    <span class="info-box-text text-center text-muted dynamic-form-main-heading">{{$dynamic_form_obj::$input_type_labels[$dynamic_form_obj::TYPE_TEXT]}}</span>
                                                    <div class="form-group">
                                                        <label>{{$dynamic_form_obj::$input_type_labels[$dynamic_form_obj::TYPE_TEXT]}}</label>
                                                        <input type="text" class="form-control" disabled placeholder="Type in text format">
                                                    </div>
                                                </div>
                                                @include('admin.dynamic_form._input-tab')
                                            </div>
                                        </div>
                                    </li>
                                                                        
                                    {{-- Number filed --}}
                                    <li class="ui-state-highlight draggable w-100 h-auto">
                                        <div class="info-box bg-light">
                                            <div class="info-box-content">
                                                <div class="dummy-content">
                                                    <span class="info-box-text text-center text-muted dynamic-form-main-heading">{{$dynamic_form_obj::$input_type_labels[$dynamic_form_obj::TYPE_NUMBER]}}</span>
                                                    <div class="form-group">
                                                        <label>{{$dynamic_form_obj::$input_type_labels[$dynamic_form_obj::TYPE_NUMBER]}}</label>
                                                        <input type="number" class="form-control" value="1234" placeholder="Type in text format">
                                                    </div>
                                                </div>
                                                @include('admin.dynamic_form._number-tab')
                                            </div>
                                        </div>
                                    </li>
                                    

                                    {{-- select option --}}
                                    <li class="ui-state-highlight draggable w-100 h-auto">
                                        <div class="info-box bg-light">
                                            <div class="info-box-content">
                                                <div class="dummy-content">
                                                    <span class="info-box-text text-center text-muted dynamic-form-main-heading">{{$dynamic_form_obj::$input_type_labels[$dynamic_form_obj::TYPE_DATE]}}</span>
                                                    <div class="form-group">
                                                        <label>{{$dynamic_form_obj::$input_type_labels[$dynamic_form_obj::TYPE_DATE]}}</label>
                                                        <input type="date" class="form-control" placeholder="Select date">
                                                    </div>
                                                </div>
                                                @include('admin.dynamic_form._date-tab')
                                            </div>
                                        </div>
                                    </li>
                                    
                                    {{-- select option --}}
                                    <li class="ui-state-highlight draggable w-100 h-auto">
                                        <div class="info-box bg-light">
                                            <div class="info-box-content">
                                                <div class="dummy-content">
                                                    <span class="info-box-text text-center text-muted dynamic-form-main-heading">{{$dynamic_form_obj::$input_type_labels[$dynamic_form_obj::TYPE_SELECT]}}</span>
                                                    <div class="form-group">
                                                        <label>{{$dynamic_form_obj::$input_type_labels[$dynamic_form_obj::TYPE_SELECT]}}</label>
                                                        <select name="" class="form-control" id="">
                                                            <option value="">Value 1</option>
                                                            <option value="">Value 2</option>
                                                            <option value="">Value 3</option>
                                                            <option value="">Value 4</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                @include('admin.dynamic_form._select-tab')
                                            </div>
                                        </div>
                                    </li>  
                                    

                                    {{-- radio button --}}
                                    <li class="ui-state-highlight draggable w-100 h-auto">
                                        <div class="info-box bg-light">
                                            <div class="info-box-content">
                                                <div class="dummy-content">
                                                    <span class="info-box-text text-center text-muted dynamic-form-main-heading">{{$dynamic_form_obj::$input_type_labels[$dynamic_form_obj::TYPE_RADIO]}}</span>
                                                    <div class="form-group">
                                                        <label>{{$dynamic_form_obj::$input_type_labels[$dynamic_form_obj::TYPE_RADIO]}} (For Single Choice)</label><br>
                                                        <div class="icheck-primary d-inline update_unique_ids ">
                                                            <input type="radio" name="radio_value" id="radioPrimary1" checked >
                                                            <label for="radioPrimary1">Radio Button 1</label>
                                                        </div>
                                                        <div class="icheck-primary d-inline update_unique_ids ">
                                                            <input type="radio" name="radio_value" id="radioPrimary2" >
                                                            <label for="radioPrimary2">Radio Button 2</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                @include('admin.dynamic_form._radio-tab')
                                            </div>
                                        </div>
                                    </li>                                      
                                    
                                    {{-- checkbox --}}
                                    <li class="ui-state-highlight draggable w-100 h-auto">
                                        <div class="info-box bg-light">
                                            <div class="info-box-content">
                                                <div class="dummy-content">
                                                    <span class="info-box-text text-center text-muted dynamic-form-main-heading">{{$dynamic_form_obj::$input_type_labels[$dynamic_form_obj::TYPE_CHECKBOX]}}</span>
                                                    <div class="form-group">
                                                        <label>{{$dynamic_form_obj::$input_type_labels[$dynamic_form_obj::TYPE_CHECKBOX]}} (For Single Choice)</label><br>
                                                        <div class="icheck-primary d-inline update_unique_ids ">
                                                            <input type="checkbox" id="checkbox1" >
                                                            <label for="checkbox1">Checkbox Button 1</label>
                                                        </div>
                                                        <div class="icheck-primary d-inline update_unique_ids ">
                                                            <input type="checkbox" id="checkbox2" >
                                                            <label for="checkbox2">Checkbox Button 2</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                @include('admin.dynamic_form._checkbox-tab')
                                            </div>
                                        </div>
                                    </li>                                      

                                    {{-- checkbox --}}
                                    <li class="ui-state-highlight draggable w-100 h-auto">
                                        <div class="info-box bg-light">
                                            <div class="info-box-content">
                                                <div class="dummy-content">
                                                    <span class="info-box-text text-center text-muted dynamic-form-main-heading">{{$dynamic_form_obj::$input_type_labels[$dynamic_form_obj::TYPE_FILE]}}</span>
                                                    <div class="form-group">
                                                        <label>{{$dynamic_form_obj::$input_type_labels[$dynamic_form_obj::TYPE_FILE]}} (For Single Choice)</label><br>
                                                        <input type="file" class="w-100 btn btn-primary p-2">
                                                    </div>
                                                </div>
                                                @include('admin.dynamic_form._upload-tab')
                                            </div>
                                        </div>
                                    </li>                                      

                                    {{-- text filed --}}
                                    <li class="ui-state-highlight draggable w-100 h-auto">
                                        <div class="info-box bg-light">
                                            <div class="info-box-content">
                                                <div class="dummy-content">
                                                    <span class="info-box-text text-center text-muted dynamic-form-main-heading">{{$dynamic_form_obj::$input_type_labels[$dynamic_form_obj::TYPE_TEXTAREA]}}</span>
                                                    <div class="form-group">
                                                        <label>{{$dynamic_form_obj::$input_type_labels[$dynamic_form_obj::TYPE_TEXTAREA]}}</label>
                                                        <textarea name="" id="" class="form-control" cols="30" rows="5" disabled placeholder="Type in long paragraph"></textarea>
                                                    </div>
                                                </div>
                                                @include('admin.dynamic_form._textarea-tab')
                                            </div>
                                        </div>
                                    </li>                                    

                                </ul>
                            </div>
                        </div>
                    </div>


                    @php $clone_counter = $clone_option_counter = 1; @endphp
                    <div class="col-sm-6">
                        <div class="card card-primary card-outline">
                            <!-- Default box -->
                            <div class="card-body">
                                {!! Form::open(['action' => 'App\Http\Controllers\AdminControllers\DynamicFormController@update_form', 'role' => 'form','id' => 'dynamic_form','onsubmit' => 'return submitFrm(this)', 'enctype' => 'multipart/form-data']) !!}
                                <ul id="sortable" class="p-0">
                                    <li class="sortable-disabled">
                                        <div class="form-group">
                                            <label>Map Location on <b>Google Map</b> </label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-map-marker"></i></span>
                                                </div>
                                                <input type=" text" class="form-control" disabled placeholder="click here to select location">
                                            </div>
                                        </div>
                                    </li>
                                    @foreach ($aRows as $input_data)
                                    <li class="bg-success pb-1 w-100 h-auto ui-sortable-handle">
                                        <div class="info-box bg-light">
                                            <div class="info-box-content">
                                                @if ($input_data['input_type'])
                                                    @include('admin.dynamic_form.'.$dynamic_form_obj::$dynamic_tab_name[$input_data['input_type']],compact('dynamic_form_obj','clone_counter','clone_option_counter','input_data'))
                                                @endif
                                            </div>
                                        </div>
                                    </li>
                                    @php $clone_counter += 3; $clone_option_counter += 1; @endphp
                                    @endforeach
                                </ul>
                                <div class="box-footer intrfacr">
                                    <button type="reset" class="btn btn-default toastsDefaultSuccess">Refresh</button>
                                    <button type="submit" class="btn btn-info pull-right">Submit</button>
                                </div>
                                {!! Form::close() !!}
                            </div>
        
                        </div>
                    </div>
                </div>
                <input type="text" id="" value="{{$clone_counter}}" id="" class="form-control clone-counter"> {{-- to calculate checkbox and radio count --}}
                <input type="text" id="" value="{{$clone_option_counter}}" id="" class="form-control clone-option-counter"> {{-- to calculate input type clone count --}}    
            </div>
        </section>
       <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
@push('add-css')
<style>
.input-content{
    border: 2px dashed #686868;
    /* padding: 9px 10px; */
    background: aliceblue;
}

.collapse-panel-box{
    padding: 12px 15px;
}
.cursor-d {
    cursor: default !important
}
.child-append-section > li:first-child .remove-clone-btn{
    display: none;
}
.draggable .input-content{
    display: none;
}
/* .collapse{
display: inline !important; 
} */

#sortable .dummy-content{
    display: none;
}
#sortable .input-content{
    display: block !important;
}
.dynamic-form-main-heading,
.dynamic-form-heading{
    font-size: 23px;
    text-transform: capitalize;
    text-align: left !important;
    padding: 2px 6px;
    background: #d5d5d5;
    text-decoration: none !important;
    color: #403e3e !important;
}
.dynamic-form-heading a{
    text-decoration: none !important;
}
.dynamic-form-heading  span{
    color: #403e3e !important;
    font-weight: bold;
}

.draggable.ui-state-highlight{
    cursor: move
}
</style>
@endpush
@push('add-script')
    <script>
    $(function() {
        saveFormData = function(){
            var frmData = new FormData($('#dynamic_form')[0]);
            console.log($('#dynamic_form')[0],frmData);
        }

        $(document).on('click','.remove-clone-btn',function(){
            if(confirm('Do you want to remove this input filed')){
                $(this).parents($(this).data('parent')).remove();
            }
        });

        $(document).on('click','.add-clone-btn',function(){
            // let target_counter = $(this).parents('#master-parent').find('.clone-counter');
            let parent_node = $(this).parents('.parent-option-div');
            var append_html = parent_node.find('.child-append-section > li:first-child').html();
            parent_node.find('.child-append-section').append("<li class='sortable-disabled'>"+append_html+"</li>");
        });

        /* replace string on text */
        var replaceAll = function(str, find, replace) {
            return str.replace(new RegExp(find, 'g'), replace);
        }

        $( "#sortable").sortable({
            revert: true,
            items: "li:not(.sortable-disabled)",
            // group: 'ui-state-highlight',
            update: function(event, ui) {
                let target_counter = $(this).parents('#master-parent').find('.clone-counter');
                let target_option_counter = $(this).parents('#master-parent').find('.clone-option-counter');

                ui.item.find('.dummy-content').remove(); // remove draggable view
                var dynamic_index_box = ui.item.find('.change_input_index');
                if(dynamic_index_box.length > 0){  // update all input field index
                    for(i=0;i<dynamic_index_box.length;++i){
                        let input_node = $(dynamic_index_box[i]);
                        var name_attrib_value = input_node.attr('name');
                        input_node.attr('name', replaceAll(name_attrib_value,'input_array','input_array_' + parseInt(target_option_counter.val())));
                    };
                }
                var dynamic_collapse_target = ui.item.find('.dynamic-collapse-target');
                if(dynamic_collapse_target.length > 0){  // update all input field index
                    for(i=0;i<dynamic_collapse_target.length;++i){
                        let toggle_input_node = $(dynamic_collapse_target[i]);
                        let toggle_id_string = 'toggle_id_string' + parseInt(target_option_counter.val());
                        if(typeof toggle_input_node.attr('id') !== "undefined"){
                            var name_attrib_value = toggle_input_node.attr('id');
                            toggle_input_node.attr('id', toggle_id_string);
                        }
                        if(typeof toggle_input_node.attr('href') !== "undefined"){
                            var name_attrib_value = toggle_input_node.attr('id');
                            toggle_input_node.attr('href', '#'+toggle_id_string);
                        }
                    };
                }

                
                target_option_counter.val(parseInt(target_option_counter.val()) + 1);

                var target_array = ui.item.find('.update_unique_ids');
                if(target_array.length > 0){  // update checkbox id for all input type
                    for(i=0;i<target_array.length;++i){
                        let first_node = $(target_array[i]).find('input');
                        let second_node = $(target_array[i]).find('label');
                        first_node.attr('id', 'unique_col_' + target_counter.val());
                        second_node.attr('for','unique_col_' + target_counter.val());
                        target_counter.val(parseInt(target_counter.val()) + 1);
                        
                    };
                }
                saveFormData();
            },
            receive:function(event , ui){
                // let target_counter = $(this).parents('#master-parent').find('.clone-counter');
                // let target_option_counter = $(this).parents('#master-parent').find('.clone-option-counter');
            },
        });
        $( ".draggable" ).draggable({
            connectToSortable: "ul#sortable",
            helper: "clone",
            revert: "invalid",
            start: function( event, ui ) {
              $(this).addClass('bg-primary'); 
            },
            stop: function( event, ui ) {
              $(this).addClass('bg-danger'); 
            },
            // helper: function(e) { // to resize on drag
            //     var original = $(e.target).hasClass("ui-draggable") ? $(e.target) :  $(e.target).closest(".ui-draggable");
            //     return original.clone().css({
            //         // width: original.width(),
            //         height: 'auto',
            //     });                
            // },
        });
        $( "ul, li" ).disableSelection();
    });


    </script>
@endpush
