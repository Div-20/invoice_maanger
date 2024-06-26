<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\LocationArea;
use App\Models\LocationCity;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AjaxController extends Controller
{

    /**
     * return parent category id for product module
     * @param string search
     * @return array
     * */
    public function getParentCategory(Request $request)
    {
        $response_array = [];
        if (request('search') && strlen(request('search')) >= 3 && $request->method('ajax')) {
            $aRows = Category::select('id', 'name', 'icon')->where('name', 'like', '%' . request('search') . '%')->whereNull('parent_id')->get();
            if ($aRows) {
                $response_array['items'] = $aRows;
            }
        }
        return response()->json($response_array);
    }

    /**
     * return parent brands id for product module
     * @param string search
     * @return json
     * */
    public function getParentBrand(Request $request)
    {
        $response_array = [];
        if (request('search') && strlen(request('search')) >= 3 && $request->method('ajax')) {
            $aRows = Brand::select('id', 'name', 'icon')->where('name', 'like', '%' . request('search') . '%')->whereNull('parent_id')->get();
            if ($aRows) {
                $response_array['items'] = $aRows;
            }
        }
        return response()->json($response_array);
    }


    public function getCity(Request $request)
    {
        $id = $request->id;
        $result = LocationCity::where([['state_id', $id], ['status', LocationCity::STATUS_ACTIVE]])->orderBy('name', 'ASC')->pluck('name', 'id')->toArray();
        $html = '<option value="" selected>---Select City---</option>';
        if ($result) {
            foreach ($result as $key => $value) {
                $html .= '<option value="' . $key . '">' . $value . '</option>';
            }
        }
        return $html;
        die();
    }

    public function getDistrict(Request $request)
    {
        $id = $request->id;
        $result = LocationCity::where('state_id', $id)->whereNull('district_id')->orderBy('name', 'ASC')->pluck('name', 'id')->toArray();
        $html = '<option value="" selected>---Select District---</option>';
        if ($result) {
            foreach ($result as $key => $value) {
                $html .= '<option value="' . $key . '">' . $value . '</option>';
            }
        }
        return $html;
        die();
    }

    public function getRegion(Request $request)
    {
        $id = $request->id;
        $result = LocationCity::where('state_id', $id)->where([['status', LocationCity::STATUS_ACTIVE], ['region_status', 1]])->orderBy('name', 'ASC')->pluck('name', 'id')->toArray();
        $html = '<option value="" selected>---Select City---</option>';
        if ($result) {
            foreach ($result as $key => $value) {
                $html .= '<option value="' . $key . '">' . $value . '</option>';
            }
        }
        return $html;
        die();
    }

    public function getArea(Request $request)
    {
        $id = $request->id;
        $result = LocationArea::where('city_id', $id)->orderBy('name', 'ASC')->pluck('name', 'id')->toArray();
        $html = '<option value="" selected>---Select Area---</option>';
        if ($result) {
            foreach ($result as $key => $value) {
                $html .= '<option value="' . $key . '">' . $value . '</option>';
            }
        }
        return $html;
        die();
    }
}
