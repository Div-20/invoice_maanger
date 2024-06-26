<?php
namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use App\Models\DynamicForm;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\RequiredIf;

class DynamicFormController extends Controller
{
    public function dynamic_form_page(request $request)
    {
        $dynamic_form_obj = new DynamicForm();
        $aRows = $dynamic_form_obj::orderBy('order_by', 'ASC')->get();
        return view('admin.dynamic_form.manage', compact('aRows', 'dynamic_form_obj'));
    }

    private function arrangeOptionArray(array $request_option_array): array
    {
        $option_array = [];
        if (isset($request_option_array['title']) && isset($request_option_array['value'])) {
            foreach ($request_option_array['title'] as $key => $element) {
                if ($element != '' && isset($request_option_array['value'][$key]) && $request_option_array['value'][$key] != '') {
                    $option_array[$request_option_array['value'][$key]] = $element;
                }
            }
        }
        return $option_array;
    }

    private function checkDefaultValue(array $request_option_array, $default): bool
    {
        $response = false;
        foreach ($request_option_array as $key => $element) {
            if ($default && $key == $default) {
                $response = true;
            }
        }
        return $response;
    }

    public function update_form(Request $request)
    {
        $dynamic_form_obj = new DynamicForm();
        $request_array = $request->only('form_data');
        $i = 0;
        $return_array = [];
        if (isset($request_array['form_data']) && count($request_array['form_data'])) {
            foreach ($request_array['form_data'] as $order_key => $input_ordered_options) {

                $validator = Validator::make($input_ordered_options, [
                    'input_type' => [
                        'required',
                        Rule::in(array_keys(DynamicForm::$input_type_labels))
                    ],
                    'label' => 'required',
                    // 'placeholder' => 'required_if:input_type,in:' . implode(',', DynamicForm::$placeholder_validation),
                    'options.*' => [
                        'required_if:input_type,in:' . implode(',', DynamicForm::$option_validation),
                        'array',
                    ],
                ]);

                if (!empty($validator->errors()->messages())) {
                    foreach ($validator->errors()->messages() as $key => $errorMessage) {
                        return response()->json(['status' => false, 'errors' => $errorMessage[0]], Response::HTTP_BAD_REQUEST);
                    }
                }

                $json_save_array = array_merge(DynamicForm::$save_json_array, $input_ordered_options);
                $json_save_array['order_by'] = ++$i;
                foreach ($json_save_array as $key_element => $key_value) {

                    if (in_array($key_element, DynamicForm::$checkbox_validation)) {
                        $json_save_array[$key_element] = $key_value == 'on' ? true : false;
                    }
                    // manage options array
                    if ($key_element == 'options') {
                        $json_save_array[$key_element] = $this->arrangeOptionArray($key_value);
                    }
                }

                if ($json_save_array['default'] && in_array($json_save_array['input_type'], DynamicForm::$option_validation)) {
                    $default_status = $this->checkDefaultValue($json_save_array['options'], $json_save_array['default']);
                    if (!$default_status) {
                        return response()->json(["status" => true, "action" => "showError", "errors" => 'Default selected value should be same in ' . DynamicForm::$input_type_labels[$json_save_array['input_type']]]);
                    }
                }
                array_push($return_array, $json_save_array);
            }
        }
        DynamicForm::truncate();
        foreach ($return_array as $key => $value) {
            DynamicForm::create($value);
        }
        $msg = 'Form Update successfully';
        $msgView = view('include.msg', compact('msg'))->render();
        return response()->json(['status' => true, 'action' => 'show-model-refresh', 'message' => $msgView]);
    }
}
