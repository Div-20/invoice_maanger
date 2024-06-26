<?php

namespace App\Helpers;

use App\Models\Asset;
use App\Models\Brand;
use App\Models\Category;
use App\Models\CMS;
use App\Models\Faq;
use App\Models\LocationCity;
use App\Models\LocationCountry;
use App\Models\LocationStates;
use App\Models\ManageCurrency;
use App\Models\Slider;
use App\Models\User;
use Illuminate\Http\Request;

class CustomServiceHelper
{

    public function updateRequest(Request $request)
    {
        $requestIds = $request->ck_id;
        if (empty($requestIds)) {
            return back()->with('error', 'Please select data');
        }
        switch ($request->tagName) {
            case 'manage_country':
                $aRows = LocationCountry::whereIn('id', $requestIds)->get();
                break;
            case 'manage_states':
                $aRows = LocationStates::whereIn('id', $requestIds)->get();
                break;
            case 'manage_cities':
                $aRows = LocationCity::whereIn('id', $requestIds)->get();
                break;
            case 'manage_users':
                $aRows = User::whereIn('id', $requestIds)->get();
                break;
            case 'category':
                $aRows = Category::whereIn('id', $requestIds)->get();
                break;
            case 'manage_cms':
                $aRows = CMS::whereIn('id', $requestIds)->get();
                break;
            case 'manage_faqs':
                $aRows = Faq::whereIn('id', $requestIds)->get();
                break;
            case 'product-brands':
                $aRows = Brand::whereIn('id', $requestIds)->get();
                break;
            case 'slider':
                $aRows = Slider::whereIn('id', $requestIds)->get();
                break;
            case 'manage_currencies':
                $aRows = ManageCurrency::whereIn('id', $requestIds)->get();
                break;
            case 'manage_assets':
                $aRows = Asset::whereIn('id', $requestIds)->get();
                break;

            default:
                $aRows = array();
                break;
        }

        if (empty($aRows) || empty($aRows->toArray())) {
            return back()->with('error', 'No Data found');
        } else {
            $msg = "Invalid Action";
            if (isset($request->active)) {

                foreach ($aRows as $key => $aRow) {
                    $aRow->status = 10;
                    $aRow->update();
                }
                $msg = "Request activate successfully";
            }
            if (isset($request->inactive)) {
                foreach ($aRows as $key => $aRow) {
                    $aRow->status = 5;
                    $aRow->update();
                }
                $msg = "Request inactive successfully";
            }
            if (isset($request->delete)) {
                foreach ($aRows as $key => $aRow) {
                    $aRow->delete();
                }
                $msg = "Request data delate successfully";
            }
            if (isset($request->webShow)) {
                foreach ($aRows as $key => $aRow) {
                    $aRow->show_web = 1;
                    $aRow->update();
                }
                $msg = "Request update successfully";
            }
        }

        return redirect()->back()->with('success', $msg);
    }
}
