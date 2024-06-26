<?php

namespace App\Http\Controllers\AdminControllers;

use App\Exports\ExportAsset;
use App\Helpers\MediaHelper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Imports\AssetImport;
use App\Imports\ValidatedAssetImport;
use App\Models\Asset;
use App\Models\AssetReview;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use DB,File,Auth;
use App\Models\AssetType;
use App\Models\BuildingBlock;
use App\Models\BuildingList;
use App\Models\DepartmentList;
use App\Models\FloorList;
use Illuminate\Auth\Events\Validated;

class AssetController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request  $request)
    {
        $aQuery = $request->query();
        $result = Asset::orderBy('id', 'desc');
        if ($request->has('search')) {
            $search_value = $request->get('search');
            $result->where(function($query) use ($search_value){
                $search_code = explode('/',$search_value);
                if(!empty($search_code)){
                    $query->where(function($qr) use($search_code){
                        $building = isset($search_code[0])?BuildingList::where('code',$search_code[0])->first():'';
                        $asset_type = isset($search_code[1])?AssetType::where('code',$search_code[1])->first():'';
                        if(isset($building)){
                            $qr->where('building_id',$building->id);
                        }
                        if(!empty($asset_type)){
                            $qr->where('asset_type_id',$asset_type->id);
                        }
                        if(!empty($search_code[2])){
                            $qr->where('unique_id',$search_code[2]);
                        }
                    });
                }

                $query->orWhere('asset_json->department', 'LIKE', '%' . $search_value . '%');
                $query->orWhere('asset_json->building', 'LIKE', '%' . $search_value . '%');
                $query->orWhere('asset_json->asset_type', 'LIKE', '%' . $search_value . '%');
           });
        }

        // Start Report code
        $asset = new Asset;
        $table = $asset->getTable();
        $columns  = \Schema::getColumnListing($table);
        //Report
        if ($request->has('exptype')) {
            if (strtoupper(trim($request->get('exptype'))) == "EXCEL") {
                ini_set('memory_limit', '-1');
                ob_end_clean();
                return Excel::download(new ExportAsset($result->get(), $request->status, $columns, $request->all()), 'asset_report.xlsx');
            }
        }
        // End Report code

        if(Auth::guard('admin')->check()){
            $aRows = $result->paginate(request('paginate') ?: 20);
            return view('admin.assets.index', compact('aRows', 'aQuery','columns'));
        }else{
            $result->where('created_by',Auth::user()->id);
            $aRows = $result->paginate(request('paginate') ?: 20);
            return view('users.assets.index', compact('aRows', 'aQuery','columns'));
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $aRow = array();
        $asset_type = AssetType::select('id','name')->get();
        $buildings = BuildingList::select('id','name')->get();
        $departments = DepartmentList::select('id','name')->get();
        $floors = FloorList::select('id','name')->get();

        if(Auth::guard('admin')->check()){
            return view('admin.assets.manage',compact('aRow','asset_type','buildings','departments','floors'));
        }else{
            return view('users.assets.manage',compact('aRow','asset_type','buildings','departments','floors'));
        }
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
        if(Auth::guard('admin')->check()){
        $aUser = \Auth::guard('admin')->user();
        }else{
            $aUser = Auth::user();
        }
        $messages = [
            'required' => ':attribute is required',
        ];
        $rules = [
            'asset_type' => 'required',
            'department_id' => 'required',
            'building_id' => 'required',
            'floor_id' => 'required',
            'asset_name' => 'required',
            'reg_no' => ['required_if:asset_type,Vehicle']
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return back()->withErrors($validator->errors())->withInput();
        }
        $assetType = AssetType::where('name', $request->asset_type)->first();
        $asset = new Asset();
        if($request->asset_type == 'Vehicle'){
            $asset_json_data = [
                'vehicle_type' => $request->vehicle_type,
                'reg_no' => $request->reg_no,
                'chesis_no' => $request->chesis_no,
                'policy_no' => $request->policy_no,
                'insurance_company' => $request->insurance_company,
                'sum_insurred' => $request->sum_insurred,
                'premium' => $request->premium,
                'polution_valid_upto' => $request->polution_valid_upto,
                'make' => $request->make,
                'model' => $request->model,
                'capacity' => $request->capacity,
                'year_of_mfg' => $request->year_of_mfg,
                'year_of_purchase' => $request->year_of_purchase,
                'working_condition' => $request->working_condition,
                'name' => $request->name,
                'ref_no' => $request->ref_no,
                'allocated_to' => $request->allocated_to,
                're_located_to' => $request->re_located_to,
            ];

            $asset->unique_id = $request->reg_no;
            $asset->asset_json = json_encode($asset_json_data);
            $asset->created_by = $aUser->id;
            $asset->building_code_id = 0;
            $asset->asset_type_id = $assetType->id;

        }else{
            $buildingData = BuildingList::where('id', $request->building_id)->first();


            $floor_list = FloorList::where('id', $request->floor_id)->first();
            $department_list = DepartmentList::where('id', $request->department_id)->first();
            $asset_json_data = [
                'building'=>$buildingData->name,
                'building_code'=>$buildingData->code,
                'floor'=>$floor_list->name,
                'department'=>$department_list->name,
                'asset_type'=>$request->asset_type,
                'asset_type_code'=>$assetType->code,
                'room_no' => $request->room_no,
                'asset_name' => $request->asset_name,
                'made_of' => $request->made_of,
                'detail' => $request->detail,
                'make' => $request->make,
                'model' => $request->model,
                'capacity' => $request->capacity,
                'year_of_mfg' => $request->year_of_mfg,
                'year_of_purchase' => $request->year_of_purchase,
                'working_condition' => $request->working_condition,
                'name' => $request->name,
                'ref_no' => $request->ref_no,
                'allocated_to' => $request->allocated_to,
                're_located_to' => $request->re_located_to,
            ];
            $find_building_block = BuildingBlock::where('building_id', $request->building_id)->where('floor_id', $request->floor_id)->where('department_id', $request->department_id)->where('room_no', $request->room_no)->first();
            if (empty($find_building_block)) {
                $building_block = new BuildingBlock();
                $building_block->building_id = $request->building_id;
                $building_block->floor_id = $request->floor_id;
                $building_block->department_id = ($request->department_id) ? $request->department_id : 0;
                $building_block->room_no = $request->room_no;
                $building_block->save();
                $building_block_id = $building_block->id;
            } else {
                $building_block_id = $find_building_block->id;
            }
            $unique_id = $this->find_unique_id($assetType->id);
            $asset->unique_id = $unique_id;
            $asset->asset_json = json_encode($asset_json_data);
            $asset->created_by = $aUser->id;
            $asset->building_code_id = $building_block_id;
            $asset->asset_type_id = $assetType->id;
            $asset->building_id= $request->building_id;

        }
        if(Auth::guard('admin')->check()){
            $asset->status = 1;
        }
        $asset->save();
        DB::table('asset_last_unique_id')->updateOrInsert(['asset_type_id' => $assetType->id],['number' => $unique_id]);
        if(Auth::guard('admin')->check()){
            return redirect()->route('admin.assets.index')->with('success', 'Asset added SuccessFully');
        }else{
            return redirect()->route('user.assets.index')->with('success', 'Asset added SuccessFully');
        }


    }

    public function find_unique_id($asset_code_id){
        $find_asset = DB::table('asset_last_unique_id')->where('asset_type_id', $asset_code_id)->first();
        if(!empty($find_asset)) {
            $unique_no = $find_asset->number;
        } else {
            $unique_no = '';
        }
        $unique_id = (!empty($find_asset) ? sprintf("%05s", $unique_no + 1) : '00001');
        $find_asset =Asset::where('unique_id',$unique_id)->where('asset_type_id', $asset_code_id)->first();
        if(!empty($find_asset)) {
           DB::table('asset_last_unique_id')->updateOrInsert(['asset_type_id' => $asset_code_id],['number' => $unique_id]);
           return $this->find_unique_id($asset_code_id);
        }else{
          return $unique_id;
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Asset  $asset
     * @return \Illuminate\Http\Response
     */
    public function show(Asset $asset)
    {
        $asset_data  = $asset;
        // dd($asset);
        if(Auth::guard('admin')->check()){
            return view('admin.assets.show',compact('asset_data'));
        }else{
            return view('users.assets.show',compact('asset_data'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Asset  $asset
     * @return \Illuminate\Http\Response
     */
    public function edit(Asset $asset)
    {
        $aRow = array();
        $asset_type = AssetType::select('id','name')->get();
        $buildings = BuildingList::select('id','name')->get();
        $departments = DepartmentList::select('id','name')->get();
        $floors = FloorList::select('id','name')->get();
        $aRow=$asset;
        if(Auth::guard('admin')->check()){
            return view('admin.assets.manage',compact('aRow','asset_type','buildings','departments','floors'));
        }else{
            return view('users.assets.manage',compact('aRow','asset_type','buildings','departments','floors'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Asset  $asset
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Asset $asset)
    {
        if(Auth::guard('admin')->check()){
            $aUser = \Auth::guard('admin')->user();
            }else{
                $aUser = Auth::user();
            }
            $messages = [
                'required' => ':attribute is required',
            ];
            $rules = [
                'asset_type' => 'required',
                'department_id' => 'required',
                'building_id' => 'required',
                'floor_id' => 'required',
                'asset_name' => 'required',
                'reg_no' => ['required_if:asset_type,Vehicle']
            ];

            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return back()->withErrors($validator->errors())->withInput();
            }


            $assetType = AssetType::where('name', $request->asset_type)->first();

            if($request->asset_type == 'Vehicle'){
                $asset_json_data = [
                    'vehicle_type' => $request->vehicle_type,
                    'reg_no' => $request->reg_no,
                    'chesis_no' => $request->chesis_no,
                    'policy_no' => $request->policy_no,
                    'insurance_company' => $request->insurance_company,
                    'sum_insurred' => $request->sum_insurred,
                    'premium' => $request->premium,
                    'polution_valid_upto' => $request->polution_valid_upto,
                    'make' => $request->make,
                    'model' => $request->model,
                    'capacity' => $request->capacity,
                    'year_of_mfg' => $request->year_of_mfg,
                    'year_of_purchase' => $request->year_of_purchase,
                    'working_condition' => $request->working_condition,
                    'name' => $request->name,
                    'ref_no' => $request->ref_no,
                    'allocated_to' => $request->allocated_to,
                    're_located_to' => $request->re_located_to,
                    'remarks'=> $request->remarks
                ];

                $asset->unique_id = $request->reg_no;
                $asset->asset_json = json_encode($asset_json_data);
                $asset->created_by = $aUser->id;
                $asset->building_code_id = 0;
                $asset->asset_type_id = $assetType->id;

            }else{
                $buildingData = BuildingList::where('id', $request->building_id)->first();
                $find_asset = Asset::where('unique_id', 'like', '%' . $buildingData->code.'/'.$assetType->code . '%')->orderBy('id', 'desc')->first();
                if(isset($find_asset) && !empty($find_asset)){
                    $unique_asset = explode('/',$find_asset->unique_id);
                    $unique_no = $unique_asset[2];
                }else{
                    $unique_no = '';
                }
               // $unique_id = ($buildingData->code .'/'.$assetType->code.'/'.(!empty($find_asset) ? sprintf("%05s", $unique_no + 1) : '00001'));
                $floor_list = FloorList::where('id', $request->floor_id)->first();
                $department_list = DepartmentList::where('id', $request->department_id)->first();
                $asset_json_data = [
                    'building'=>$buildingData->name,
                    'building_code'=>$buildingData->code,
                    'floor'=>$floor_list->name,
                    'department'=>$department_list->name,
                    'asset_type'=>$request->asset_type,
                    'asset_type_code'=>$assetType->code,
                    'room_no' => $request->room_no,
                    'asset_name' => $request->asset_name,
                    'made_of' => $request->made_of,
                    'detail' => $request->detail,
                    'make' => $request->make,
                    'model' => $request->model,
                    'capacity' => $request->capacity,
                    'year_of_mfg' => $request->year_of_mfg,
                    'year_of_purchase' => $request->year_of_purchase,
                    'working_condition' => $request->working_condition,
                    'name' => $request->name,
                    'ref_no' => $request->ref_no,
                    'allocated_to' => $request->allocated_to,
                    're_located_to' => $request->re_located_to,
                    'remarks'=> $request->remarks
                ];
                $find_building_block = BuildingBlock::where('building_id', $request->building_id)->where('floor_id', $request->floor_id)->where('department_id', $request->department_id)->where('room_no', $request->room_no)->first();
                if (empty($find_building_block)) {
                    $building_block = new BuildingBlock();
                    $building_block->building_id = $request->building_id;
                    $building_block->floor_id = $request->floor_id;
                    $building_block->department_id = ($request->department_id) ? $request->department_id : 0;
                    $building_block->room_no = $request->room_no;
                    $building_block->save();
                    $building_block_id = $building_block->id;
                } else {
                    $building_block_id = $find_building_block->id;
                }
                $asset->unique_id = $asset->unique_id;
                $asset->asset_json = json_encode($asset_json_data);
                $asset->created_by = $aUser->id;
                $asset->building_code_id = $building_block_id;
                $asset->asset_type_id = $assetType->id;
                $asset->building_id= $request->building_id;

            }
            if(Auth::guard('admin')->check()){
                $asset->status = 1;
            }
            $asset->save();
            if(Auth::guard('admin')->check()){
                return redirect()->route('admin.assets.index')->with('success', 'Asset updated SuccessFully');
            }else{
                return redirect()->route('user.assets.index')->with('success', 'Asset updated SuccessFully');
            }


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Asset  $asset
     * @return \Illuminate\Http\Response
     */
    public function destroy(Asset $asset)
    {
        $asset->delete();
        return redirect()->back()->with('success', 'Asset deleted SuccessFully');
    }

     /**
     * Show the form for creating a import resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function import_asset(Request $request)
    {

        if ($request->isMethod('post')) {

            $this->validate(
                $request,
                [
                    //'inqubatee_excel'   =>'required|in:doc,csv,xlsx,xls,docx,ppt,odt,ods,odp',
                    'asset_file'   => 'required',
                ],
                ['asset_file.in' => 'Please Select .xlsx File for Import']
            );

            $asset_excel = $request->file('asset_file');
            if ($asset_excel) {

                $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($asset_excel->getRealPath());
                $sheetCount = $spreadsheet->getSheetCount();
                if ($sheetCount > 1) {
                    return redirect()->back()->withErrors(['file' => 'The uploaded file must contain only one sheet.']);
                }
                try {
                 Excel::import(new ValidatedAssetImport, $asset_excel);
                } catch (\Exception $e) {
                    return redirect()->back()->with(['error' => $e->getMessage()]);
                }
                try {
                   $excel = Excel::import(new AssetImport, $asset_excel);
                } catch (\Exception $e) {
                   return redirect()->back()->with(['error' => $e->getMessage()]);
                }
                if ($excel) {
                    $destinationPath = public_path('uploads/asset_excel');
                    if (!File::isDirectory($destinationPath)) {
                        File::makeDirectory($destinationPath, 0777, true, true);
                    }
                    $ext = strtolower($asset_excel->getClientOriginalExtension());
                    $file_org_name = strtolower($asset_excel->getClientOriginalName());
                    $file_org_name = preg_replace('/\..+$/', '_', $file_org_name);
                    $file_org_name = preg_replace('/\s+/', '_', $file_org_name);
                    $_asset_excel = $file_org_name . date('Y_m_d') . '.' . $ext;
                    $asset_excel->move($destinationPath, $_asset_excel);
                }
            }
            $type = 'success';
            $message = 'Asset Excel Import Successfully.';
            if(Auth::guard('admin')->check()){
               return redirect(route('admin.assets.index'))->with([$type => $message]);
            }else{
                return redirect(route('user.assets.index'))->with([$type => $message]);
            }
        }
        if(Auth::guard('admin')->check()){
            return view('admin.assets.import_asset');
        }else{
            return view('users.assets.import_asset');
        }

    }
     /**
     * generate qrcode the specified resource from storage.
     *
     * @param  \App\Models\Asset  $asset
     * @return \Illuminate\Http\Response
     */
    public function qrcode($id)
    {
       $asset= Asset::where('id',$id)->first();
        if(Auth::guard('admin')->check()){
            return view('admin.assets.qrcode',compact('asset'));
        }else{
            return view('users.assets.qrcode',compact('asset'));
        }
    }

    public function review_list(Request  $request)
    {

        $result = AssetReview::orderBy('id', 'desc');
        if ($request->has('search')) {
            $search_value = $request->get('search');
           if(trim($request->get('search')) != ''){
                $search_value = $request->get('search');
                $result->where(function($query) use ($search_value){
                    $query->whereHas('asset',function($query2) use ($search_value){
                        $query2->where('unique_id', 'LIKE', '%' . $search_value . '%');
                        $query2->orWhere('asset_json->asset_name', 'LIKE', '%' . $search_value . '%');
                    });
                });
            }
        }
       $asset_review= $result->paginate(request('paginate') ?: 20);

        return view('admin.assets.asset_review',compact('asset_review'));
    }

    public function update_status(Request $request){
        $input = $request->all();
        $id = $input["asset_id"];
        $task = Asset::findorfail($id);

            $data = [
                "status" => $input["status"],
               // "reason" => $input["reason"]
            ];
        $task->fill($data)->save();
        return redirect()->back()->with('message', 'Successfully updated!');
    }


}
