<?php

namespace App\Http\Controllers\AdminControllers;

use App\Helpers\CustomHelper;
use App\Helpers\MediaHelper;
use App\Http\Controllers\Controller;
use App\Models\LocationArea;
use App\Models\LocationCity;
use App\Models\LocationCountry;
use App\Models\LocationStates;
use App\Models\Media;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($type)
    {

        if ($type == 'country') {
            $aRows = LocationCountry::orderBy('name', 'ASC')->get();
            $path = 'admin.location.country';
        } elseif ($type == 'state') {
            $aRows = LocationStates::orderBy('name', 'ASC')->get();
            $path = 'admin.location.state';
        } elseif ($type == 'area') {
            $aRows = LocationArea::orderBy('name', 'ASC')->get();
            $path = 'admin.location.area';
        }
        return view($path, compact('aRows'));
    }

    public function city($state_id)
    {
        $state_detail = LocationStates::where('id', $state_id)->first();
        if (!$state_detail) {
            return redirect()->back()->withError('Invalid Request');
        }
        $aRows = LocationCity::where('state_id', $state_detail->id)->orderBy('name', 'ASC')->get();
        return view('admin.location.city', compact('aRows', 'state_detail'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($type, $id = null)
    {
        $district = $aRows = $country = $state = $city = array();
        $tier_type  = LocationCity::$city_tier_type;
        if ($type == 'state') {
            $country = LocationCountry::orderBy('id', 'ASC')->pluck('name', 'id')->toArray();
        }
        if ($type == 'city') {
            $district = LocationCity::where('state_id', $id)->whereNull('district_id')->orderBy('name', 'ASC')->pluck('name', 'id')->toArray();
        }
        if ($type == 'area') {
            $state = LocationStates::orderBy('name', 'ASC')->pluck('name', 'id')->toArray();
            $city = array(' ' => ' ');
        }
        return view('admin.location.addLocation', compact('aRows', 'type', 'country', 'state', 'city', 'district', 'tier_type', 'id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $aVal = $request->only('type', 'name', 'code', 'currency', 'country_id', 'state_id', 'district_id', 'tier_type', 'pin_code');
        $type = $aVal['type'];
        $messages = [
            'required' => 'The :attribute field is required.',
            'country_id.required_if' => 'Select valid country.',
            'code.required_if' => 'Enter valid country code.',
            'pin_code.required_if' => 'Enter valid pin code',
            'state_id.required_if' => 'Invalid request',
        ];
        $rules = ['name' => 'required'];

        if ($type == 'country') {
            $table = 'location_countries';
            $model_name = new LocationCountry();
        } elseif ($type == 'state') {
            $table = 'location_states';
            $model_name = new LocationStates();
        } elseif ($type == 'city') {
            $table = 'location_cities';
            $model_name = new LocationCity();
        } elseif ($type == 'area') {
            $table = 'location_areas';
            $model_name = new LocationArea();
        }

        $rules = [
            'name' => 'required|unique:' . $table,
            'code' => 'required_if:type,==,country',
            'pin_code' => 'required_if:type,==,city|Numeric',
            'country_id' => 'required_if:type,==,state',
            'state_id' => 'required_if:type,==,city',
        ];
        $this->validate($request, $rules, $messages);

        if ($request->hasFile('icon')) {
            $files = $request->file('icon');
            $result = MediaHelper::uploadImage($files, Media::$folder_name[Media::LOCATION]);
            if (!$result) {
                $msg = 'Please add valid file';
                $msgView = view('include.msgError', compact('msg'))->render();
                return response()->json(["status" => "success", "action" => "showpopup", "message" => $msgView]);
            }
            $aVal['icon'] = $result;
        }
        $model_name::create($aVal);
        $msg = 'Add new ' . $type . ' Successfully';
        $msgView = view('include.msg', compact('msg'))->render();
        return response()->json(["status" => "success", "action" => "showpopup", "message" => $msgView]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\country  $country
     * @return \Illuminate\Http\Response
     */
    public function show($type, $id)
    {
        $district = $aRow = $country = $state = $city = array();
        $tier_type  = LocationCity::$city_tier_type;
        if ($type == 'country') {
            $aRow = LocationCountry::findOrFail($id);
        } elseif ($type == 'state') {
            $aRow = LocationStates::findOrFail($id);
            $country = LocationCountry::orderBy('id', 'ASC')->pluck('name', 'id')->toArray();
        } elseif ($type == 'city') {
            $aRow = LocationCity::findOrFail($id);
            $district = LocationCity::where('state_id', $aRow->state_id)->whereNull('district_id')->orderBy('name', 'ASC')->pluck('name', 'id')->toArray();
        } elseif ($type == 'area') {
            $aRow = LocationArea::findOrFail($id);
            $state = LocationStates::orderBy('name', 'ASC')->pluck('name', 'id')->toArray();
            $city = LocationCity::orderBy('name', 'ASC')->where('state_id', $aRow->state_id)->pluck('name', 'id')->toArray();
        }
        return view('admin.location.updateLocation', compact('aRow', 'country', 'state', 'city', 'type', 'district', 'tier_type'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\country  $country
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $aVal = $request->only('type', 'name', 'code', 'currency', 'country_id', 'state_id', 'district_id', 'tier_type', 'pin_code');
        $messages = ['required' => 'The :attribute field is required.', 'pin_code.required_if' => 'Enter valid pin code'];
        $rules = ['name' => 'required'];

        $rules = [
            'name' => 'required',
            'pin_code' => 'required_if:type,==,city|Numeric',
        ];
        $this->validate($request, $rules, $messages);
        $type = $aVal['type'];
        if ($type == 'country') {
            $aRow = LocationCountry::findOrFail($request->id);
        } elseif ($type == 'state') {
            $aRow = LocationStates::findOrFail($request->id);
        } elseif ($type == 'city') {
            $aRow = LocationCity::findOrFail($request->id);
        } elseif ($type == 'area') {
            $aRow = LocationArea::findOrFail($request->id);
        }
        if ($request->hasFile('icon')) {
            $files = $request->file('icon');
            $result = MediaHelper::uploadImage($files, Media::$folder_name[Media::LOCATION], false, 'image', ($aRow->icon ?? false));
            if (!$result) {
                $msg = 'Please add valid file';
                $msgView = view('include.msgError', compact('msg'))->render();
                return response()->json(["status" => "success", "action" => "showpopup", "message" => $msgView]);
            }
            $aVal['icon'] = $result;
        }
        $aRow->update($aVal);
        $msg = 'Update ' . $type . ' Successfully';
        $msgView = view('include.msg', compact('msg'))->render();
        return response()->json(array("status" => "success", "action" => "showpopup", "message" => $msgView));
    }
}
