<?php

namespace App\Http\Controllers\AdminControllers;

use App\Helpers\MediaHelper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Media;
use Illuminate\Support\Facades\Validator;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $aQuery = $request->query();
        $aRows = Brand::filter()->orderBy('id', 'desc')->paginate(request('paginate') ?: 20);
        return view('admin.brands.index', compact('aRows', 'aQuery'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $aRow = $parent_list = array();
        return view('admin.brands.manage', compact('aRow', 'parent_list'));
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
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return back()->withErrors($validator->errors())->withInput();
        }
        $aData = $request->all('name', 'parent_id', 'description');
        if ($request->hasFile('image')) {
            $image_name = MediaHelper::uploadImageMedia($request->file('image'), Media::$directory[Media::BRAND]);
            if (!$image_name) {
                return redirect()->back()->withError('invalid media file');
            }
            $image_name['media_type'] = Media::BRAND;
            $media_obj = Media::create($image_name);
            $aData['image'] = $media_obj->id;
        }
        Brand::create($aData);
        return redirect()->route('admin.brands.index')->with('success', 'Brand add SuccessFully');
    }

    /**
     * view the specified resource.
     *
     * @param  \App\Models\Brand $brand
     * @return \Illuminate\Http\Response
     */
    public function edit(Brand $brand)
    {
        $parent_list = array();
        $brand::$get_media_name = true;
        $aRow = $brand;
        if ($aRow->parent) {
            array_push($parent_list, [$aRow->parent->id => $aRow->parent->name]);
        }

        return view('admin.brands.manage', compact('aRow', 'parent_list'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Brand $brand
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Brand $brand)
    {
        $messages = [
            'required' => ':attribute is required',
        ];
        $rules = [
            'image[]' => 'mimes:jpeg,bmp,png,gif',
            'name' => 'required',
        ];

        $validation = Validator::make($request->all(), $rules, $messages);
        if ($validation->fails()) {
            return back()->withErrors($validation->errors());
        }

        $aData = $request->all();
        if ($request->hasFile('image')) {
            $image_name = MediaHelper::uploadImageMedia($request->file('image'), Media::$directory[Media::BRAND]);
            if (!$image_name) {
                return redirect()->back()->withError('invalid media file');
            }
            $brand->media?->delete();
            $image_name['media_type'] = Media::BRAND;
            $media_obj = Media::create($image_name);
            $aData['image'] = $media_obj->id;
        }
        $brand->update($aData);
        return redirect()->route('admin.brands.index')->with('success', 'Update request SuccessFully');
    }
}
