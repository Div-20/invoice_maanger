<?php

namespace App\Http\Controllers\Api;

use App\Helpers\CustomHelper;
use App\Helpers\MediaHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\CMSResource;
use App\Http\Resources\UserResource;
use App\Models\CMS;
use App\Models\Faq;
use App\Models\LeadManagements;
use App\Models\LocationCity;
use App\Models\LocationCountry;
use App\Models\LocationStates;
use App\Models\Media;
use App\Models\Transactions;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{

    /** 
     * User update request
     * @param string name
     * @param string email
     * @param string mobile
     * @param string password
     * @param string password_confirm
     * @param string image
     */
    public function profile(Request $request)
    {
        $aUser = $request->user();
        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string',
                'email' => 'required|unique:users,email,' . $aUser->id . '|email',
                'mobile' => 'required|unique:users,mobile,' . $aUser->id . '|digits:10',
            ]);
            if (!empty($validator->errors()->messages())) {
                foreach ($validator->errors()->messages() as $key => $errorMessage) {
                    return response()->json(['status' => false, 'message' => $errorMessage[0]], Response::HTTP_BAD_REQUEST);
                }
            }
            $aData = $request->only('email', 'name', 'mobile', 'address');

            if ($request->password) {
                $validator = Validator::make($request->all(), [
                    'password'        => 'required|string|min:9',
                    'password_confirm' => 'required|min:9|required_with:password|same:password',
                ]);
                if (!empty($validator->errors()->messages())) {
                    foreach ($validator->errors()->messages() as $key => $errorMessage) {
                        return response()->json(['status' => false, 'message' => $errorMessage[0]], Response::HTTP_BAD_REQUEST);
                    }
                }
                $aData['password'] = Hash::make($request->password);
            }

            if ($request->image) {
                $files = $request->image;
                $result = MediaHelper::uploadBase64Image($files, $aUser->unique_id . '_profile_' . CustomHelper::generatePassword(3, 3), Media::$folder_name[Media::CONSUMER], false, $aUser->image ?? false);
                if (!$result['status']) {
                    return response()->json(['status' => false, 'message' => 'Select valid image'], Response::HTTP_BAD_REQUEST);
                }
                $result['image']['media_type'] = Media::CONSUMER;
                $mediaObj = Media::create($result['image']);
                $aData['image'] = $mediaObj->id;
            }
            $aUser->update($aData);
            return response()->json(['status' => true, 'data' => new UserResource($aUser), 'message' => 'Profile update successfully.'], Response::HTTP_OK);
        }
        return response()->json(['status' => true, 'data' => new UserResource($aUser)], Response::HTTP_OK);
    }

    /** 
     * Amount Us page content
     */
    public function aboutUs()
    {
        $aRow = CMS::where('slug', 'like', "%" . CMS::ABOUT_PAGE . "%")->first();
        if (!$aRow) {
            return response()->json(['status' => false, 'message' => 'About page content not updated'], Response::HTTP_BAD_REQUEST);
        }
        return response()->json(['status' => true, 'data' => new CMSResource($aRow)], Response::HTTP_OK);
    }

    /** 
     * Contact page page content
     */
    public function contactUs()
    {
        $aRow = CMS::where('slug', 'like', "%" . CMS::CONTACT_PAGE . "%")->first();
        if (!$aRow) {
            return response()->json(['status' => false, 'message' => 'Contact Us page content not updated'], Response::HTTP_BAD_REQUEST);
        }
        return response()->json(['status' => true, 'data' => new CMSResource($aRow)], Response::HTTP_OK);
    }


    /** 
     * Trams and conditions page content
     */
    public function tramsCondition()
    {
        $aRow = CMS::where('slug', 'like', "%" . CMS::TRAMS_PAGE . "%")->first();
        if (!$aRow) {
            return response()->json(['status' => false, 'message' => 'Trams And Condition Page content not updated'], Response::HTTP_BAD_REQUEST);
        }
        return response()->json(['status' => true, 'data' => new CMSResource($aRow)], Response::HTTP_OK);
    }

    /** 
     * policy page content
     */
    public function tramsPolicy()
    {
        $aRow = CMS::where('slug', 'like', "%" . CMS::POLICY_PAGE . "%")->first();
        if (!$aRow) {
            return response()->json(['status' => false, 'message' => 'Policy Page content not updated'], Response::HTTP_BAD_REQUEST);
        }
        return response()->json(['status' => true, 'data' => new CMSResource($aRow)], Response::HTTP_OK);
    }

    /** 
     * policy page content
     */
    public function faqs()
    {
        $aRows = Faq::select('title', 'description', 'type')->with('allChildren')->orderBy('id', 'desc')->whereNull('parent_id')->where('status', Faq::STATUS_ACTIVE)->get();
        if ($aRows->isEmpty()) {
            return response()->json(['status' => false, 'message' => 'FAQ content not updated'], Response::HTTP_BAD_REQUEST);
        }
        return response()->json(['status' => true, 'data' => $aRows], Response::HTTP_OK);
    }

    /** 
     * Get all country data
     */
    public function country()
    {
        $aRows = LocationCountry::select('id', 'name', 'code', 'currency')->orderBy('id', 'desc')->where('status', LocationCountry::STATUS_ACTIVE)->get();
        if ($aRows->isEmpty()) {
            return response()->json(['status' => false, 'message' => 'No record found.'], Response::HTTP_BAD_REQUEST);
        }
        return response()->json(['status' => true, 'data' => $aRows], Response::HTTP_OK);
    }

    /** 
     * Get all state records
     * @param integer $country_id
     */
    public function state($country_id)
    {
        $country = LocationCountry::select('name', 'id', 'status')->where([['id', $country_id], ['status', LocationCountry::STATUS_ACTIVE]])->first();
        if (!$country) {
            return response()->json(['status' => false, 'message' => 'Invalid request.'], Response::HTTP_BAD_REQUEST);
        }
        $aRows = LocationStates::select('id', 'name')->orderBy('id', 'desc')->where([['country_id', $country_id], ['status', LocationStates::STATUS_ACTIVE]])->get();
        if ($aRows->isEmpty()) {
            return response()->json(['status' => false, 'message' => 'No record found.'], Response::HTTP_BAD_REQUEST);
        }
        return response()->json(['status' => true, 'data' => $aRows], Response::HTTP_OK);
    }

    /** 
     * Get all cities recodes
     * @param integer $country_id
     * @param integer $state_id
     */
    public function cities($country_id, $state_id)
    {
        $country = LocationCountry::select('name', 'id', 'status')->where([['id', $country_id], ['status', LocationCountry::STATUS_ACTIVE]])->first();
        if (!$country) {
            return response()->json(['status' => false, 'message' => 'Invalid request.'], Response::HTTP_BAD_REQUEST);
        }
        $aRows = LocationCity::select('id', 'name', 'icon')->orderBy('id', 'desc')->where([['state_id', $state_id], ['status', LocationStates::STATUS_ACTIVE]])->get();
        if ($aRows->isEmpty()) {
            return response()->json(['status' => false, 'message' => 'No record found.'], Response::HTTP_BAD_REQUEST);
        }
        return response()->json(['status' => true, 'data' => $aRows], Response::HTTP_OK);
    }


    /** 
     * Contact us page
     * Save user data
     * @param string $name
     * @param string $email
     * @param string $mobile
     * @param object $attachment
     * @param string $message
     */
    public function contact_us(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'mobile' => 'required',
                'email' => 'required|email',
                'message' => 'required|max:500',
            ], [
                'name.required' => 'name is required',
                'email.required' => 'Email address Is required',
                'mobile.required' => 'Mobile Is required',
                'message.required' => 'Min 10 word message is required',
            ]);
            if (!empty($validator->errors()->messages())) {
                foreach ($validator->errors()->messages() as $key => $errorMessage) {
                    return response()->json(['status' => false, 'message' => $errorMessage[0]], Response::HTTP_BAD_REQUEST);
                }
            }
            $aData = $request->only('name', 'email', 'mobile', 'message');
            if ($request->hasFile('attachment')) {
                $media_obj = MediaHelper::uploadImageMedia($request->file('attachment'), Media::$directory[Media::LEADS], false, 'doc');
                if (!$media_obj) {
                    return response()->json(['status' => false, 'message' => 'invalid file format'], Response::HTTP_BAD_REQUEST);
                }
                $media_obj['media_type'] = Media::LEADS;
                $media_obj = Media::create($media_obj);
                $save_data['link'] = $media_obj->id;
            }

            $save_data['type'] = LeadManagements::TYPE_CONTACT;
            $save_data['user_name'] = $aData['name'];
            $save_data['user_email'] = $aData['email'];
            $save_data['user_mobile'] = $aData['mobile'];
            $save_data['content'] = CustomHelper::replace($aData['message']);
            LeadManagements::create($save_data);
            return response()->json(['status' => true, 'message' => 'Your request save successfully'], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'message' => 'Something went wrong.'], Response::HTTP_BAD_REQUEST);
        }
    }

    /** 
     * Contact us page
     * Save user data
     * @param string $email
     */
    public function newsletter(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
            ], [
                'email.required' => 'Email address Is required',
            ]);
            if (!empty($validator->errors()->messages())) {
                foreach ($validator->errors()->messages() as $key => $errorMessage) {
                    return response()->json(['status' => false, 'message' => $errorMessage[0]], Response::HTTP_BAD_REQUEST);
                }
            }
            $aData = $request->only('email');
            $save_data['type'] = LeadManagements::TYPE_NEWSLETTER;
            $save_data['user_email'] = $aData['email'];
            $lead_obj = LeadManagements::where($save_data)->first();
            if ($lead_obj) {
                $lead_obj->counter = intval($lead_obj->counter) + 1;
                $lead_obj->save();
            } else {
                LeadManagements::create($save_data);
            }
            return response()->json(['status' => true, 'message' => 'Your request save successfully'], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'message' => 'Something went wrong.'], Response::HTTP_BAD_REQUEST);
        }
    }
}
