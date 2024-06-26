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
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class ValidatedAssetImport implements ToModel, WithHeadingRow, ToCollection
{

    public function collection(Collection $rows)
    {

        foreach ($rows as $key => $row) {
            if ($row['asset_type_code'] == "") {
                throw \Illuminate\Validation\ValidationException::withMessages(['error' => 'Asset Type Code row not found']);
            } else {
                if (isset($rows[$key + 1])) {
                    $current = $rows[$key];
                    $next = $rows[$key + 1];
                    if ($current['asset_type_code'] && $next['asset_type_code'] && $current['asset_type_code'] != $next['asset_type_code']) {
                        throw \Illuminate\Validation\ValidationException::withMessages(['error' => 'Asset Type Code column not same found']);
                    }
                }
            }
        }
    }
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    private $row = 1;
    public function model(array $row)
    {


        if (isset($row['s_no']) && $row['s_no']) {

            // if(!isset($row['asset_sno'])){
            //     throw \Illuminate\Validation\ValidationException::withMessages(['error' => 'Asset S.No row not found']);
            // }
            if ($row['asset_type_code'] == "") {
                throw \Illuminate\Validation\ValidationException::withMessages(['error' => 'Asset Type Code row not found']);
            }
            $asset_type_code = ($row['asset_type_code']) ? $row['asset_type_code'] : NULL;
            $asset_list = AssetType::where('code', 'like', '%' . $asset_type_code . '%')->first();
            if (empty($asset_list)) {
                throw \Illuminate\Validation\ValidationException::withMessages(['error' => 'Error found in row number ' . ++$this->row . ', Asset type Code is mismatch from asset type list']);
            } else {
                $asset_type_id = $asset_list->id;
            }
            if ($row['asset_sno'] && !str_contains($row['asset_sno'], $row['asset_type_code'])) {
                throw \Illuminate\Validation\ValidationException::withMessages(['error' => 'Error found in Asset S.No (Row number ' . ++$this->row . ')']);
            }
            if ($row['asset_sno'] && !str_contains($row['asset_sno'], $row['building_code'])) {
                throw \Illuminate\Validation\ValidationException::withMessages(['error' => 'Error found in Asset S.No (Row number ' . ++$this->row . ')']);
            }


            if (isset($row['building']) && $row['building']) {
                $building_list = BuildingList::where('code', $row['building_code'])->first();
                if (empty($building_list)) {
                    throw \Illuminate\Validation\ValidationException::withMessages(['error' => 'Error found in row number ' . ++$this->row . ', building Code is mismatch from building code list']);
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
                    $check_asset = Asset::where('unique_id', $unique_id)->where('asset_type_id', $asset_type_id)->first();
                    if (!empty($check_asset)) {
                        throw \Illuminate\Validation\ValidationException::withMessages(['error' => 'Duplicate in asset unique code (Row number ' . ++$this->row . ')']);
                    }
                }
            }
        }
    }
}
