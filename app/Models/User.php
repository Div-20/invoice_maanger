<?php

namespace App\Models;

use App\Helpers\CustomHelper;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Casts\Attribute;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'role','prime', 'name', 'email', 'mobile', 'password', 'image', 'country', 'state', 'city', 'area', 'location', 'address', 'referral'
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


    /**
     * Scope a query to only include users of a given aQuery.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param array $aQuery
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFilter($query)
    {
        if (request('search')) {
            $query->where(function ($query) {
                $query->orWhere('mobile', '=', request('search'));
                $query->orWhere('name', 'like', '%' . request('search') . '%');
                $query->orWhere('email', 'like', '%' . request('search') . '%');
            });
        }

        if (request('prime')) {
            $today = Carbon::today();
            if (request('prime') == 'prime') {
                $query->where('prime', '>', $today);
            } elseif (request('prime') == 'non-prime') {
                $query->where('prime', '<', $today);
            }
        }

        if (request('role')) {
            $query->where('role', request('role'));
        }
        if (request('blocked')) {
            if (request('blocked') == 'blocked') {
                $query->where('block', 1);
            } elseif (request('blocked') == 'unblocked') {
                $query->where('block', 0);
            }
        }
        return $query;
    }


    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $unique_token = AutoIncrement::getAutoIncrementId('auto_user');
            $model->unique_id = 'US' . $unique_token . CustomHelper::generatePassword(10 - strlen($unique_token), 2);
            $model->country = 101;
        });

        static::created(function ($model) {
            Wallet::create(['user_id' => $model->id]);
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

    public function getBalance()
    {
        return $this->wallet?->balance_amt;
    }

    public function pushNotificationDetail()
    {
        return $this->hasOne(PushNotification::class, 'user_id', '_id');
    }

    public function getState()
    {
        return $this->hasOne(states::class, 'id', 'state');
    }

    public function getCity()
    {
        return $this->hasOne(city::class, 'id', 'city');
    }

    public function wallet()
    {
        return $this->hasOne(Wallet::class, 'user_id', 'id');
    }
    // End Relations

    //Start Accessor
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


    /**
     * Check user registered
     * @param sting $request_param
     * @param sting column name
     * @param Array and condition
     * @return User/NULL
     * */
    public static function checkUserStatus($request_param, $filed = false, $conditions = array())
    {
        $aUserObj = self::where(
            $filed ?: (filter_var($request_param, FILTER_VALIDATE_EMAIL) ? 'email' : 'mobile'),
            $request_param
        );
        if (count($conditions)) {
            $aUserObj->andWhere($conditions);
        }
        return $aUserObj->first();
    }
    public function user_role()
    {
        return $this->hasOne(Role::class, 'id', 'role');
    }

}
