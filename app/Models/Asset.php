<?php

namespace App\Models;

use App\Helpers\CustomHelper;
use App\Helpers\MediaHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    use HasFactory;

    // protected $table="Assets";

    const STATUS_ACTIVE = 10;
    const STATUS_INACTIVE = 5;

    public static $status_type = [
        self::STATUS_ACTIVE => 'Active',
        self::STATUS_INACTIVE => 'In Active',
    ];

    protected $fillable = [ 'unique_id','status','asset_json','building_code_id','asset_type_id','building_id','created_by'];



    public function parent()
    {
        return $this->hasOne(self::class, 'id', 'parent_id');
    }


    // Start Accessor
    public static $get_media_url = false;
    public static $get_media_name = false;
    public function getImageAttribute($image)
    {
        if ($image) {
            $media = Media::select()->whereId($image)->first();
            if ($media) {
                if (self::$get_media_url) {
                    return asset(Media::$directory[$media->media_type] . $media->file_name);
                } else if (self::$get_media_name) {
                    return $media->file_name;
                }
            }
        }
        return $image;
    }

    public function asset_type()
    {
        return $this->hasOne(AssetType::class, 'id', 'asset_type_id');
    }
    public function building()
    {
        return $this->hasOne(BuildingList::class, 'id', 'building_id');
    }
    public function building_block()
    {
        return $this->hasOne(BuildingBlock::class, 'id', 'building_code_id');
    }

}
