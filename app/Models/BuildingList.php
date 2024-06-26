<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuildingList extends Model
{
    use HasFactory;

    protected $table = 'building_list';
    protected $fillable = [
        'id','name', 'code'
    ];
}
