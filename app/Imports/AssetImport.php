<?php

namespace App\Imports;

use App\Models\Asset;
use App\Models\AssetType;
use App\Models\BuildingBlock;
use App\Models\BuildingList;
use App\Models\DepartmentList;
use App\Models\FloorList;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Auth, DB;
use Maatwebsite\Excel\Validators\Failure;

class AssetImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    private $row = 1;
    public function model(array $row)
    {


        if (isset($row['s_no']) && $row['s_no']) {


            $asset_type_code = ($row['asset_type_code']) ? $row['asset_type_code'] : NULL;
            // $asset_list = AssetType::where('name', $row['asset_type'])->where('code', $asset_type_code)->first();
            $asset_list = AssetType::where('code', 'like', '%' . $asset_type_code . '%')->first();
            if (empty($asset_list)) {
                //$error = ['Asset type Code is mismatch from asset type list'];
                // $failures[] = new Failure(++$this->row, 'asset_type_code', $error, []);
                throw \Illuminate\Validation\ValidationException::withMessages(['error' => 'Error found in row number ' . ++$this->row . ', Asset type Code is mismatch from asset type list']);
                //throw new \Maatwebsite\Excel\Validators\ValidationException(\Illuminate\Validation\ValidationException::withMessages($error), $failures);

                // $asset_type = new AssetType();
                // $asset_type->name = $row['asset_type'];
                // $asset_type->code = $asset_type_code;
                // $asset_type->save();
                // $asset_type_id = $asset_type->id;
            } else {
                $asset_type_id = $asset_list->id;
            }


            if (isset($row['building']) && $row['building']) {
                $building_list = BuildingList::where('code', $row['building_code'])->first();
                if (empty($building_list)) {
                    $building_data = new BuildingList();
                    $building_data->name = $row['building'];
                    $building_data->code = $row['building_code'];
                    $building_data->save();
                    $building_id = $building_data->id;
                } else {
                    $building_id = $building_list->id;
                }
                $floor_list = FloorList::where('name', $row['floor'])->first();
                if (empty($floor_list)) {
                    $floor_data = new FloorList();
                    $floor_data->name = $row['floor'];
                    $floor_data->save();
                    $floor_id = $floor_data->id;
                } else {
                    $floor_id = $floor_list->id;
                }
                $department_list = DepartmentList::where('name', $row['department'])->first();
                if (empty($department_list) && $row['department']) {
                    $department_data = new DepartmentList();
                    $department_data->name = $row['department'];
                    $department_data->save();
                    $department_id = $department_data->id;
                } else {
                    if (!empty($department_list)) {
                        $department_id = $department_list->id;
                    } else {
                        $department_id = 0;
                    }
                }
                $room_no = ($row['room_no']) ? $row['room_no'] : NULL;

                $find_building_block = BuildingBlock::where('building_id', $building_id)->where('floor_id', $floor_id)->where('department_id', $department_id)->where('room_no', $room_no)->first();
                if (empty($find_building_block)) {
                    $building_block = new BuildingBlock();
                    $building_block->building_id = $building_id;
                    $building_block->floor_id = $floor_id;
                    $building_block->department_id = ($department_id) ? $department_id : 0;
                    $building_block->room_no = $room_no;
                    $building_block->save();
                    $building_block_id = $building_block->id;
                } else {
                    $building_block_id = $find_building_block->id;
                }
                if (!empty($row['asset_sno'])) {
                    $unique_asset = explode('/', $row['asset_sno']);
                    $unique_id = $unique_asset[2];
                }else{
                    $unique_id = $this->find_unique_id($asset_type_id);

                }

                $check_asset = Asset::where('unique_id', $unique_id)->where('asset_type_id', $asset_type_id)->first();
                if (empty($check_asset)) {
                    $asset = new Asset();
                    $asset->building_code_id = $building_block_id;
                    $asset->asset_type_id = $asset_type_id;
                    $asset->unique_id = $unique_id;
                    if (Auth::guard('admin')->check()) {
                        $asset->created_by = Auth::guard('admin')->user()->id;
                    } else {
                        $asset->created_by = Auth::user()->id;
                    }
                    unset($row['s_no']);
                    $asset->asset_json = json_encode($row);
                    $asset->building_id = $building_id;
                    $asset->save();
                    if (empty($row['asset_sno'])) {
                        DB::table('asset_last_unique_id')->updateOrInsert(
                            ['asset_type_id' => $asset_type_id],
                            ['number' => $unique_id]
                        );
                    }
                }
            } else {
                if ($row['vehicle_registration_no']) {
                    $check_asset = Asset::where('unique_id', $row['vehicle_registration_no'])->first();
                    if (empty($check_asset)) {
                        $asset = new Asset();
                        $asset->building_code_id = 0;
                        $asset->asset_type_id = $asset_type_id;
                        $asset->unique_id = $row['vehicle_registration_no'];
                        if (Auth::guard('admin')->check()) {
                            $asset->created_by = Auth::guard('admin')->user()->id;
                        } else {
                            $asset->created_by = Auth::user()->id;
                        }
                        unset($row['s_no']);
                        $asset->asset_json = json_encode($row);
                        $asset->building_id = 0;
                        $asset->save();
                    }
                }
            }
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

}
