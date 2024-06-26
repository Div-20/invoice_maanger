<?php

namespace App\Http\Controllers\AdminControllers;

use App\Models\FloorList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

class FloorListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $aQuery = $request->query();
        $aRows = FloorList::orderBy('id', 'desc')->paginate(request('paginate') ?: 20);
        return view('admin.floors.index', compact('aRows', 'aQuery'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $aRow = array();
        return view('admin.floors.manage', compact('aRow'));
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
        ];
        $rules = [
            'name' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return back()->withErrors($validator->errors())->withInput();
        }
        $aData = $request->only('name');

        FloorList::create($aData);
        return redirect()->route('admin.floors.index')->with('success', 'Floor added SuccessFully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\FloorList  $floorList
     * @return \Illuminate\Http\Response
     */
    public function show(FloorList $floorList)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\FloorList  $floorList
     * @return \Illuminate\Http\Response
     */
    public function edit(FloorList $floorList, $id)
    {
        $aRow = floorList::where('id', $id)->first();
        // dd($aRow);
        return view('admin.floors.manage', compact('aRow'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\FloorList  $floorList
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FloorList $floorList, $id)
    {
        $messages = [
            'required' => ':attribute is required',
        ];
        $rules = [
            'name' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return back()->withErrors($validator->errors())->withInput();
        }
        $aData = $request->only('name');
        FloorList::where('id', $id)->update($aData);


        return redirect()->route('admin.floors.index')->with('success', 'Floor updated SuccessFully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FloorList  $FloorList
     * @return \Illuminate\Http\Response
     */
    public function destroy($floorList)
    {
        $floorList = FloorList::where('id', $floorList)->first();
        if ($floorList) {
            $floorList->delete();
            return redirect()->back()->with('success', 'Floor remove successfully');
        } else {
            return redirect()->back()->with('error', 'No record found');
        }
    }
}
