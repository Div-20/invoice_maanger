<?php

namespace App\Http\Controllers\AdminControllers;

use App\Helpers\CustomHelper;
use App\Models\AssetType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;


class AssetTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $aQuery = $request->query();
        $aRows = AssetType::withCount('assets')->orderBy('id', 'desc')->paginate(request('paginate') ?: 20);
        return view('admin.asset_type.index', compact('aRows', 'aQuery'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $aRow = array();
        return view('admin.asset_type.manage', compact('aRow'));
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
            'code.max' => 'Asset Type Code must be at least 3 characters.'
        ];
        $rules = [
            'name' => 'required',
            'code' => 'required|alpha|min:3|max:3|unique:asset_type,code',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return back()->withErrors($validator->errors())->withInput();
        }
        $aData = $request->only('name', 'code');
        $aData['code'] = strtoupper(CustomHelper::seo_friendly_url($aData['code']));

        AssetType::create($aData);
        return redirect()->route('admin.asset-type.index')->with('success', 'Asset type added SuccessFully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AssetType  $assetType
     * @return \Illuminate\Http\Response
     */
    public function show(AssetType $assetType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AssetType  $assetType
     * @return \Illuminate\Http\Response
     */
    public function edit(AssetType $assetType)
    {
        $aRow = $assetType;
        return view('admin.asset_type.manage', compact('aRow'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AssetType  $assetType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AssetType $assetType)
    {
        $messages = [
            'required' => ':attribute is required',
            'code.max' => 'Asset Type Code must be at least 3 characters.'
        ];
        $rules = [
            'name' => 'required',
            'code' => 'required|alpha|min:3|max:3|unique:asset_type,code,' . $assetType->id,
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return back()->withErrors($validator->errors())->withInput();
        }
        $aData = $request->only('name', 'code',);
        $aData['code'] = strtoupper(CustomHelper::seo_friendly_url($aData['code']));
        $assetType->update($aData);

        return redirect()->route('admin.asset-type.index')->with('success', 'Asset Type updated SuccessFully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AssetType  $assetType
     * @return \Illuminate\Http\Response
     */
    public function destroy(AssetType $assetType)
    {
        $assetType->delete();
        return redirect()->back()->with('success', 'Asset Type Deleted Succesfully');
    }
}
