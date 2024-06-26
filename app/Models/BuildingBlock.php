<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuildingBlock extends Model
{
    use HasFactory;
    protected $table = 'building_block';
    protected $fillable = [
        'id','building_id' ,'floor_id' , 'department_id' , 'room_no'
    ];

    public function department()
    {
        return $this->hasOne(DepartmentList::class, 'id', 'department_id');
    }

    public function building()
    {
        return $this->hasOne(BuildingList::class, 'id', 'building_id');
    }

    public function floor()
    {
        return $this->hasOne(FloorList::class, 'id', 'floor_id');
    }
}

