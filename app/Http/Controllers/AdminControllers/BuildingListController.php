<?php

namespace App\Http\Controllers\AdminControllers;

use App\Models\BuildingList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

class BuildingListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $aQuery = $request->query();
        $aRows = BuildingList::orderBy('id', 'desc')->paginate(request('paginate') ?: 20);
        return view('admin.building_list.index', compact('aRows', 'aQuery'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $aRow = array();
        return view('admin.building_list.manage', compact('aRow'));
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
            'code.max' => 'Building Code must be at least 4 characters.'
        ];
        $rules = [
            'name' => 'required',
            'code' => 'required|alpha|min:4|max:4',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return back()->withErrors($validator->errors())->withInput();
        }
        $aData = $request->all('name', 'code',);
        $aData['code'] = strtoupper($aData['code']);
        BuildingList::create($aData);
        return redirect()->route('admin.building.index')->with('success', 'Building add SuccessFully');
        // dd($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BuildingList  $buildingList
     * @return \Illuminate\Http\Response
     */
    public function show(BuildingList $buildingList)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BuildingList  $buildingList
     * @return \Illuminate\Http\Response
     */
    public function edit(BuildingList $buildingList, $id)
    {
        $aRow = BuildingList::where('id', $id)->first();
        // dd($aRow);
        return view('admin.building_list.manage', compact('aRow'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BuildingList  $buildingList
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BuildingList $buildingList, $id)
    {
        $messages = [
            'required' => ':attribute is required',
            'code.max' => 'Building Code must be at least 4 characters.'
        ];
        $rules = [
            'name' => 'required',
            'code' => 'required|alpha|min:4|max:4',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return back()->withErrors($validator->errors())->withInput();
        }
        $aData = $request->all('name', 'code',);
        $aData['code'] = strtoupper($aData['code']);
        BuildingList::where('id', $id)->update($aData);

        return redirect()->route('admin.building.index')->with('success', 'Building updated SuccessFully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BuildingList  $buildingList
     * @return \Illuminate\Http\Response
     */
    public function destroy($buildingList)
    {
        $buildingList = BuildingList::where('id', $buildingList)->first();
        if ($buildingList) {
            $buildingList->delete();
            return redirect()->back()->with('success', 'Building delete successfully');
        } else {
            return redirect()->back()->with('error', 'No record found');
        }
    }
}
