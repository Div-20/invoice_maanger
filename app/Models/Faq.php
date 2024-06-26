<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    use HasFactory;

    protected $fillable = [
        'type', 'parent_id', 'order_by', 'title', 'description', 'status',
    ];

    // constants
    const STATUS_ACTIVE = 10;
    const STATUS_INACTIVE = 5;

    public static $status = [
        self::STATUS_ACTIVE => 'Active',
        self::STATUS_INACTIVE => 'In Active',
    ];

    const FAQ_TYPE_TITLE = 1;
    const FAQ_TYPE_TITLE_DESCRIPTION = 0;

    public static $faq_type = [
        self::FAQ_TYPE_TITLE_DESCRIPTION => 'Title with Description',
        self::FAQ_TYPE_TITLE => 'Only Title (Nested)',
    ];
    // End constants


    public static function boot()
    {
        parent::boot();

        static::deleting(function ($model) {
            foreach ($model->child as $key => $value) {
                $value->delete();
            }
        });
    }


    // relations
    public function parent()
    {
        return $this->hasOne(self::class, 'id', 'parent_id');
    }

    public function child()
    {
        return $this->hasMany(self::class, 'parent_id', 'id');
    }

    public function children()
    {
        return $this->hasMany(self::class, 'parent_id', '_id')->select('title', 'description', 'type', 'parent_id')->where('status', self::STATUS_ACTIVE);
    }

    public function allChildren()
    {
        return $this->children()->with('allChildren');
    }
    // End relations
}
