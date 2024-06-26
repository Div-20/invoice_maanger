<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FloorList extends Model
{
    use HasFactory;

    protected $table = 'floor_list';
    protected $fillable = [
        'id','name'
    ];
}
