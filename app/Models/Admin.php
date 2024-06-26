<?php

namespace App\Models;

use App\Helpers\CustomHelper;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Admin extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name', 'email', 'password', 'mobile',  'state', 'city', 'area', 'address', 'image', 'location'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {

            $unique_id = "ADM" . CustomHelper::generatePassword(9, 2);
            while (self::where('unique_id', $unique_id)->first()) {
                $unique_id = "ADM" . CustomHelper::generatePassword(9, 2);
            }
            $model->unique_id = $unique_id;
        });

        static::deleted(function ($model) {
            $model->media?->delete();
        });
    }

    // Start Relations
    public function media()
    {
        return $this->hasOne(Media::class, 'id', 'image');
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

    // geo code coordinates
    protected function location(): Attribute
    {
        return Attribute::make(
            get: fn ($location) => $location ? explode(',', $location) : NULL,
        );
    }
}
