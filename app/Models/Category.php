<?php

namespace App\Models;

use App\Helpers\CustomHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;

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
            $model->unique_id = 'CAT' . $unique_token . CustomHelper::generatePassword(10 - strlen($unique_token), 2);
        });

        static::deleting(function ($model) {
            if ($model->media) {
                $model->media->delete();
            }
            foreach ($model->childeCategory as $key => $child_category) {
                if ($child_category->media) {
                    $child_category->media->delete();
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

    public function childeCategory()
    {
        return $this->hasMany(self::class, 'parent_id', 'id');
    }
    // End Relations

    // Start Accessor
    public static $get_media_url = false;
    public static $get_media_name = false;
    public function getImageAttribute($image){
        if($image){
            $media = Media::select()->whereId($image)->first();
            if($media){
                if(self::$get_media_url){
                    return asset(Media::$directory[$media->media_type].$media->file_name);
                }else if(self::$get_media_name){
                    return $media->file_name;
                }
            }
        }
        return $image;
    }

}
