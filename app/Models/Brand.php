<?php

namespace App\Models;

use App\Helpers\CustomHelper;
use App\Helpers\MediaHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;

    const STATUS_ACTIVE = 10;
    const STATUS_INACTIVE = 5;

    public static $status_type = [
        self::STATUS_ACTIVE => 'Active',
        self::STATUS_INACTIVE => 'In Active',
    ];

    protected $fillable = [
        'image', 'icon', 'name', 'description', 'parent_id',
    ];

    public function scopeFilter()
    {
    }


    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $unique_token = AutoIncrement::getAutoIncrementId('auto_category');
            $model->unique_id = 'BND' . $unique_token . CustomHelper::generatePassword(10 - strlen($unique_token), 2);
        });

        static::deleting(function ($model) {
            if ($model->icon) {
                $model->icon->delete();
            }
            if ($model->media) {
                $model->media->delete();
            }
            foreach ($model->childBrands as $key => $child_brand) {
                if ($child_brand->icon) {
                    $child_brand->icon->delete();
                }
                if ($child_brand->media) {
                    $child_brand->media->delete();
                }
            }
        });
    }

    // Start Relations
    public function media()
    {
        return $this->hasOne(Media::class, 'id', 'image');
    }

    public function parent()
    {
        return $this->hasOne(self::class, 'id', 'parent_id');
    }

    public function childBrands()
    {
        return $this->hasMany(self::class, 'parent_id', 'id');
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
}
