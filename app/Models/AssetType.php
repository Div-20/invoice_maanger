<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetType extends Model
{
    use HasFactory;
    protected $table = 'asset_type';
    protected $fillable = [
        'id','name', 'code'
    ];
    public function assets(){
        return $this->hasMany(Asset::class,'asset_type_id','id');
    }
}
