<?php

namespace App\Models;

use App\Helpers\MediaHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    use HasFactory;

    const STATUS_ACTIVE = 10;
    const STATUS_INACTIVE = 5;

    public static $status_type = [
        self::STATUS_ACTIVE => 'Active',
        self::STATUS_INACTIVE => 'In Active',
    ];
    
    const TYPE_SITE = 1;
    const TYPE_PRODUCT = 2;
    const TYPE_STORE = 3;
    public static $type = [
        self::TYPE_SITE => 'Site Slider',
        self::TYPE_PRODUCT => 'Product Slider',
        self::TYPE_STORE => 'Shop Slider',
    ];

    protected $fillable = ['type', 'model_id', 'image', 'url', 'alt'];

    /* set accessor */
    public static $acc_image = false;
    public function getImageAttribute($image)
    {
        if (self::$acc_image) {
            return asset(Media::$directory[Media::SLIDER] . $image);
        }
        return $image;
    }

    public static function boot()
    {
        parent::boot();
        static::deleting(function ($model) {
            MediaHelper::removeImage(public_path() . Media::$directory[Media::SLIDER] . $model->image);
        });
    }
}
