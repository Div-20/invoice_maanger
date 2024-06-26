<?php

namespace App\Http\Controllers\AdminControllers;

use App\Models\BuildingBlock;
use App\Models\DepartmentList;
use App\Models\BuildingList;
use App\Models\FloorList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;


class BuildingBlockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request  $request)
    {
        $aQuery = $request->query();
        $aRows = BuildingBlock::orderBy('id', 'desc')->paginate(request('paginate') ?: 20);
        // dd($aRows);
        return view('admin.building_block.index', compact('aRows', 'aQuery'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $aRow = array();
        $buildings = BuildingList::select('id', 'name')->get();
        $departments = DepartmentList::select('id', 'name')->get();
        // dd($departments);
        $floors = FloorList::select('id', 'name')->get();
        return view('admin.building_block.manage', compact('aRow', 'buildings', 'departments', 'floors'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $messages = [
            'required' => ':attribute is required',
        ];
        $rules = [
            'department_id' => 'required',
            'building_id' => 'required',
            'floor_id' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return back()->withErrors($validator->errors())->withInput();
        }
        $aData = $request->all();
        // dd($aData);
        BuildingBlock::create($aData);
        return redirect()->route('admin.building-block.index')->with('success', 'Building Block added SuccessFully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BuildingBlock  $buildingBlock
     * @return \Illuminate\Http\Response
     */
    public function show(BuildingBlock $buildingBlock)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BuildingBlock  $buildingBlock
     * @return \Illuminate\Http\Response
     */
    public function edit(BuildingBlock $buildingBlock)
    {
        $aRow = $buildingBlock;
        $buildings = BuildingList::select('id', 'name')->get();
        $departments = DepartmentList::select('id', 'name')->get();
        $floors = FloorList::select('id', 'name')->get();
        return view('admin.building_block.manage', compact('aRow', 'buildings', 'departments', 'floors'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BuildingBlock  $buildingBlock
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BuildingBlock $buildingBlock)
    {
        $messages = [
            'required' => ':attribute is required',
        ];
        $rules = [
            'department_id' => 'required',
            'building_id' => 'required',
            'floor_id' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return back()->withErrors($validator->errors())->withInput();
        }
        $aData = $request->all();
        $buildingBlock->update($aData);

        return redirect()->route('admin.building-block.index')->with('success', 'Building block updated SuccessFully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BuildingBlock  $buildingBlock
     * @return \Illuminate\Http\Response
     */
    public function destroy($buildingBlock)
    {
        $buildingBlock = BuildingBlock::where('id', $buildingBlock)->first();
        if ($buildingBlock) {
            $buildingBlock->delete();
            return redirect()->back()->with('success', 'Building Block deleted successfully');
        } else {
            return redirect()->back()->with('error', 'No record found');
        }
    }
}
