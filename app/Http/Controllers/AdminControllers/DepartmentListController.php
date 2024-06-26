<?php

namespace App\Http\Controllers\AdminControllers;

use App\Models\DepartmentList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;


class DepartmentListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $aQuery = $request->query();
        $aRows = DepartmentList::orderBy('id', 'desc')->paginate(request('paginate') ?: 20);
        return view('admin.department_list.index', compact('aRows', 'aQuery'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $aRow = array();
        return view('admin.department_list.manage', compact('aRow'));
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
            'code.digits' => 'The Code must be at least 4 characters.'
        ];
        $rules = [
            'name' => 'required',
            'code' => 'required||alpha|min:4|max:4'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return back()->withErrors($validator->errors())->withInput();
        }
        $aData = $request->all('name', 'code');
        $aData['code'] = strtoupper($aData['code']);
        DepartmentList::create($aData);
        return redirect()->route('admin.departments.index')->with('success', 'Asset type added SuccessFully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DepartmentList  $departmentList
     * @return \Illuminate\Http\Response
     */
    public function show(DepartmentList $departmentList)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DepartmentList  $departmentList
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $aRow = DepartmentList::where('id', $id)->first();
        return view('admin.department_list.manage', compact('aRow'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DepartmentList  $departmentList
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DepartmentList $departmentList)
    {
        $messages = [
            'required' => ':attribute is required',
            'code.digits' => 'The Code must be at least 4 characters.'
        ];
        $rules = [
            'name' => 'required',
            'code' => 'required||alpha|min:4|max:4'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return back()->withErrors($validator->errors())->withInput();
        }
        $aData = $request->all('name', 'code');
        $aData['code'] = strtoupper($aData['code']);
        $departmentList->update($aData);

        return redirect()->route('admin.departments.index')->with('success', 'Department updated SuccessFully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DepartmentList  $departmentList
     * @return \Illuminate\Http\Response
     */
    public function destroy($departmentList)
    {
        $departmentList = DepartmentList::where('id', $departmentList)->first();
        if ($departmentList) {
            $departmentList->delete();
            return redirect()->back()->with('success', 'Department delete successfully');
        } else {
            return redirect()->back()->with('error', 'No record found');
        }
    }
}
