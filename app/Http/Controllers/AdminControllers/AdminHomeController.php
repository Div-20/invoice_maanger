<?php

namespace App\Http\Controllers\AdminControllers;

use App\Helpers\MediaHelper;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\LocationCity;
use App\Models\LocationStates;
use App\Models\Media;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;

class AdminHomeController extends Controller
{

    public function admin_profile(Request $request)
    {
        Admin::$get_media_name = true;
        $aRow = \Auth::guard('admin')->user();

        if ($request->isMethod('patch')) {
            $messages = [
                'required' => ':attribute is required',
                'numeric' => 'Only Numeric',
            ];
            $rules = [
                'image' => 'mimes:jpeg,bmp,png,gif',
                'name' => 'required',
                'email' => 'email|unique:admins,email,' . $aRow->id,
                'mobile' => 'required|unique:admins,mobile,' . $aRow->id . '|numeric|digits:10',
            ];

            $validation = Validator::make($request->all(), $rules, $messages);
            if ($validation->fails()) {
                return back()->withErrors($validation->errors());
            }

            $aData = $request->only('name', 'email', 'mobile', 'state', 'city', 'area', 'address');
            if ($request->hasFile('image')) {
                $image_name = MediaHelper::uploadImageMedia($request->file('image'), Media::$directory[Media::CONSUMER]);
                if (!$image_name) {
                    return redirect()->back()->withError('invalid media file');
                }
                $aRow->media?->delete();
                $image_name['media_type'] = Media::CONSUMER;
                $media_obj = Media::create($image_name);
                $aData['image'] = $media_obj->id;
            }
            if ($request->password) {
                $aData['password'] = Hash::make($request->password);
            }
            if ($request->lat && $request->long) {
                $aData['location'] = $request->lat . "," . $request->long;
            }
            $aRow->update($aData);

            return redirect()->route('admin.profile')->with('success', 'Update User Data SuccessFully');
        }
        $state = LocationStates::where('status', LocationStates::STATUS_ACTIVE)->orderBy('name', 'ASC')->pluck('name', 'id')->toArray();
        $cityObj = LocationCity::where('status', LocationCity::STATUS_ACTIVE);
        if ($aRow->state) {
            $cityObj->where('state_id', $aRow->state);
        }
        $city = $cityObj->pluck('name', 'id')->toArray();
        return view('admin.profile', compact('aRow', 'state', 'city'));
    }


    public function dashboard(Request $request)
    {
        return view('admin.dashboard');
    }

    /* Get all slider */
    public function slider()
    {
        Slider::$acc_image = true;
        $aRows = Slider::orderBy('id', 'DESC')->get();
        return view('admin.site-setting.index', compact('aRows'));
    }

    public function slider_manage(Slider $slider)
    {
        $aRow = $slider;
        return view('admin.site-setting.manage', compact('aRow'));
    }

    /** 
     * Store Slider
     */
    public function slider_update(Slider $slider, Request $request)
    {
        $messages = [
            'required' => 'The :attribute field is required.',
        ];
        $rules = [
            'type' => 'required',
            'image[]' => 'mimes:jpeg,bmp,png,gif',
            'alt' => 'required',
        ];
        $this->validate($request, $rules, $messages);
        $aData = $request->only('type', 'alt');

        if ($request->hasFile('image')) {
            $files = $request->file('image');
            $result = MediaHelper::uploadImageMedia($files, Media::$directory[Media::SLIDER], true, 'image', $slider?->image);
            if ($result == false) {
                return back()->with("error", 'Please add valid file');
            }
            $aData['image'] = $result['file_name'];
        }

        if ($slider->id) {
            $slider->update($aData);
        } else {
            Slider::create($aData);
        }
        return redirect()->route('admin.slider.index')->with('success', 'Request update SuccessFully');
    }

    public function site_logs()
    {
        $logs = File::files(storage_path('logs'));
        $aRows = [];
        foreach ($logs as $key => $log_file) {
            $aRows[$key]['object'] = $log_file;
            $file_obj = glob($log_file);
            if (file_exists($file_obj[0])) {
                $aRows[$key]['path'] = $file_obj[0];
                $aRows[$key]['modify_at'] = date("F d Y H:i:s.", filemtime($file_obj[0]));
                $aRows[$key]['file_name'] = basename($file_obj[0]);
            }
            $aRows[$key]['content'] = (File::get($log_file));
        }
        return view('admin.logs', compact('aRows'));
    }
}
