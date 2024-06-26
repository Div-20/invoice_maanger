<?php

namespace App\Http\Controllers\AdminControllers;

use App\Helpers\MediaHelper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Asset;
use App\Models\AssetReview;
use App\Models\LocationCity;
use App\Models\LocationStates;
use App\Models\Media;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $aQuery = $request->query();
        $aRows = User::select('*')->filter()->orderBy('id', 'desc')->paginate(request('paginate') ?: 20);
        $roles = Role::where('name', '!=', 'super_admin')->pluck('display_name', 'id')->toArray();
        return view('admin.users.index', compact('aRows', 'aQuery', 'roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $aRow = $city = $rewards = array();
        $state = LocationStates::where('status', LocationStates::STATUS_ACTIVE)->orderBy('name', 'ASC')->pluck('name', 'id')->toArray();
        $roles = Role::where('name', '!=', 'super_admin')->pluck('display_name', 'id')->toArray();
        return view('admin.users.userManage', compact('aRow', 'state', 'city', 'rewards', 'roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $aUser = \Auth::guard('admin')->user();

        $messages = [
            'required' => ':attribute is required',
            'numeric' => 'Only Numeric',
        ];
        $rules = [
            'image' => 'mimes:jpeg,bmp,png,gif',
            'name' => 'required',
            // 'email' => 'email|unique:users,email',
            'email' => ['email:rfc,dns', 'regex:/(.+)@(.+)\.(.+)/i', 'unique:users', 'max:255'],
            'mobile' => 'digits:10|required|numeric|unique:users,mobile',
            'password' => 'required|string|min:8',
            'role' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return back()->withErrors($validator->errors())->withInput();
        }

        $aData = $request->only('name', 'email', 'mobile', 'password', 'state', 'city', 'area', 'address', 'role');
        if ($request->hasFile('image')) {
            $image_name = MediaHelper::uploadImageMedia($request->file('image'), Media::$directory[Media::CONSUMER]);
            if (!$image_name) {
                return redirect()->back()->withError('invalid media file');
            }
            $image_name['media_type'] = Media::CONSUMER;
            $media_obj = Media::create($image_name);
            $aData['image'] = $media_obj->id;
        }
        if ($request->lat && $request->long) {
            $aData['location'] = $request->lat . "," . $request->long;
        }


        $aData['password'] = Hash::make($aData['password']);
        User::create($aData);
        return redirect()->route('admin.users.index')->with('success', 'User add SuccessFully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\models\admin\userDetail  $userDetail
     * @return \Illuminate\Http\Response
     */
    public function show(user $user)
    {
        // $user::$get_media_url = true;
        $aRow = $user;
        $state = LocationStates::where('status', LocationStates::STATUS_ACTIVE)->orderBy('name', 'ASC')->pluck('name', 'id')->toArray();
        $cityObj = LocationCity::where('status', LocationCity::STATUS_ACTIVE);
        if ($aRow->state) {
            $cityObj->where('state_id', $aRow->state);
        }
        $city = $cityObj->orderBy('name', 'ASC')->pluck('name', 'id')->toArray();
        return view('admin.users.view-user', compact('aRow', 'state', 'city'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\models\admin\userDetail  $userDetail
     * @return \Illuminate\Http\Response
     */
    public function edit(user $user)
    {
        //$user::$get_media_name = true;
        $aRow = $user;
        $state = LocationStates::where('status', LocationStates::STATUS_ACTIVE)->orderBy('name', 'ASC')->pluck('name', 'id')->toArray();
        $cityObj = LocationCity::where('status', LocationCity::STATUS_ACTIVE);
        if ($aRow->state) {
            $cityObj->where('state_id', $aRow->state);
        }
        $city = $cityObj->pluck('name', 'id')->toArray();
        $roles = Role::where('name', '!=', 'super_admin')->pluck('display_name', 'id')->toArray();
        return view('admin.users.userManage', compact('aRow', 'state', 'city', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\models\admin\userDetail  $userDetail
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, user $user)
    {

        $messages = [
            'required' => ':attribute is required',
            'numeric' => 'Only Numeric',
        ];
        $rules = [
            'image[]' => 'mimes:jpeg,bmp,png,gif',
            'name' => 'required',
            'email' => ['max:255', 'email:rfc,dns', 'regex:/(.+)@(.+)\.(.+)/i', 'unique:users,email,' . $user->id],
            'mobile' => 'required|unique:users,mobile,' . $user->id . '|numeric|digits:10',
        ];

        $validation = Validator::make($request->all(), $rules, $messages);
        if ($validation->fails()) {
            return back()->withErrors($validation->errors());
        }

        $aData = $request->only('name', 'email', 'mobile', 'state', 'city', 'area', 'role');
        if ($request->hasFile('image')) {
            $image_name = MediaHelper::uploadImageMedia($request->file('image'), Media::$directory[Media::CONSUMER]);
            if (!$image_name) {
                return redirect()->back()->withError('invalid media file');
            }
            $user->media?->delete();
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

        $user->update($aData);

        return redirect()->route('admin.users.index')->with('success', 'Update User Data SuccessFully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\models\admin\userDetail  $userDetail
     * @return \Illuminate\Http\Response
     */

    public function makeUserPrime(Request $request, user $user)
    {
        $aRow = $user;
        if ($request->isMethod('post')) {
            $rules = ['prime' => 'required',];
            $this->validate($request, $rules);
            $toDay = Carbon::today();
            $enterDate = Carbon::parse($request->prime);
            if ($enterDate < $toDay) {
                return response()->json(["status" => "success", "action" => "showError", "errors" => array('0' => 'Enter Valid Date')]);
            }
            $aData['prime'] = $enterDate;
            $aRow->update($aData);
            $msg = $aRow->name . ' become prime user Successfully';
            $msgView = view('include.msg', compact('msg'))->render();
            return response()->json(["status" => "success", "action" => "showpopup", "message" => $msgView]);
        }

        return view('admin.users.makeprime', compact('aRow'));
    }

    /* block user for login */
    public function blockUser($id, $value)
    {
        $aRow = user::findOrFail($id);
        $aRow->block = $value;
        $aRow->update();
        $msg = (!$value) ? 'User Unblocked Successfully' : 'User Blocked Successfully';
        return redirect()->back()->with('success', $msg);
    }
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return redirect()->intended('/home');
        }

        return redirect('/login')->with('error', 'Invalid credentials. Please try again.');
   }

   public function qrcode(Request $request){

        $asset =  Asset::where('unique_id', base64_decode($request->unique_id))->first();

        return view('users.physical_verification', compact('asset'));
   }
    public function review_asset(Request $request){
        $asset = Asset::where('unique_id',$request->qr_code)->first();
        if(!empty($asset)){
            $asset_review = new AssetReview();
            $asset_review->user_id = Auth::user()->id;
            $asset_review->asset_id = $asset->id;
            $asset_review->status = $request->status;
            $asset_review->review = $request->remark;
            $asset_review->save();
           return redirect()->route('home')->with('success', 'Update Asset review Data SuccessFully');
        }else{
            return redirect()->back()->with('error', 'Invalid Access');
        }

    }
}
