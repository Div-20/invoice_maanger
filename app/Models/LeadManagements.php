<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeadManagements extends Model
{
    use HasFactory;

    // leads status
    const STATUS_INACTIVE = 5;
    const STATUS_ACTIVE = 10;
    const STATUS_RECEIVE = 11;
    const STATUS_SCHEDULE = 14;
    const STATUS_CANCEL = 12;
    const STATUS_COMPLETE = 13;

    public static $status = [
        self::STATUS_INACTIVE => 'In Active',
        self::STATUS_ACTIVE => 'Active',
        self::STATUS_RECEIVE => 'Receive',
        self::STATUS_SCHEDULE => 'Schedule',
        self::STATUS_CANCEL => 'Canceled',
        self::STATUS_COMPLETE => 'Complete',
    ];
    public static $status_bg = [
        self::STATUS_INACTIVE => 'bg-warning',
        self::STATUS_ACTIVE => 'bg-primary',
        self::STATUS_RECEIVE => 'bg-light',
        self::STATUS_SCHEDULE => 'bg-warning',
        self::STATUS_CANCEL => 'bg-danger',
        self::STATUS_COMPLETE => 'bg-success',
    ];
    // End leads status

    // Leads Type
    const TYPE_CONTACT = 1;
    const TYPE_NEWSLETTER = 2;
    // End Leads Type



    protected $fillable = ['type', 'service_id', 'user_name', 'user_email', 'link', 'user_mobile', 'staff_id', 'content', 'counter', 'call_date'];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $unique_token = AutoIncrement::getAutoIncrementId('auto_leads');
            $model->unique_id = 'LD-' . time() . '-' . $unique_token;
        });
    }

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
                $query->orWhere('user_mobile', '=', request('search'));
                $query->orWhere('user_name', 'like', '%' . request('search') . '%');
                $query->orWhere('user_email', 'like', '%' . request('search') . '%');
            });
        }
        if (request('status')) {
            $query->where('status', request('status'));
        }
        return $query;
    }

    public function media()
    {
        return $this->hasOne(Media::class, 'id', 'link');
    }
}
