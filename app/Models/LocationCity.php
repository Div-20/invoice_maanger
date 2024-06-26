<?php

namespace App\Models;

use App\Helpers\MediaHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LocationCity extends Model
{
    use HasFactory;

    const STATUS_ACTIVE = 10;
    const STATUS_INACTIVE = 5;

    protected $fillable = ['name', 'state_id', 'district_id', 'region_status', 'pin_code', 'icon', 'tier_type'];

    const CITY_TIER_1 = 1;
    const CITY_TIER_2 = 2;
    const CITY_TIER_3 = 3;

    public static $city_tier_type = [
        self::CITY_TIER_1 => 'TR 1 City',
        self::CITY_TIER_2 => 'TR 2 City',
        self::CITY_TIER_3 => 'TR 3 City',
    ];

    public static $city_tier_image = [
        self::CITY_TIER_1 => 'tier-1.png',
        self::CITY_TIER_2 => 'tier-2.png',
        self::CITY_TIER_3 => 'tier-3.png',
    ];

    public static function boot()
    {
        parent::boot();

        static::deleted(function ($model) {
            $path = public_path() . Media::$directory[Media::LOCATION];
            if ($model->icon) {
                MediaHelper::removeImage($path . $model->icon);
            }
        });

    }


    public function state()
    {
        return $this->hasOne(LocationStates::class, 'id', 'state_id');
    }

    public function subCity()
    {
        return $this->hasOne(self::class, 'district_id', 'id');
    }

    public function subCites()
    {
        return $this->hasMany(self::class, 'district_id', 'id');
    }

    public function district()
    {
        return $this->hasOne(self::class, 'id', 'district_id');
    }

    public static $acc_icon = false;
    public function getIconAttribute($icon)
    {
        if (self::$acc_icon) {
            return asset('uploads/locations/' . $icon);
        }
        return $icon;
    }
}
