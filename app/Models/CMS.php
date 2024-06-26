<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CMS extends Model
{
    use HasFactory;

    protected $table = 'cms';

    protected $fillable = ['title', 'sub_title', 'description', 'short_description', 'slug'];

    // constants
    const STATUS_ACTIVE = 10;
    const STATUS_INACTIVE = 5;

    public static $status = [
        self::STATUS_ACTIVE => 'Active',
        self::STATUS_INACTIVE => 'In Active',
    ];

    const ABOUT_PAGE = 'about-us';
    const CONTACT_PAGE = 'contact-us';
    const TRAMS_PAGE = 'trams-condition';
    const POLICY_PAGE = 'trams-policy';

    public static $slug_type = [
        self::ABOUT_PAGE => 'About page',
        self::CONTACT_PAGE => 'Contact Us page',
        self::TRAMS_PAGE => 'Trams And Condition Page',
        self::POLICY_PAGE => 'Policy Page',
    ];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if ($model->description) {
                $model->short_description = htmlentities(htmlspecialchars($model->short_description));
            }
            if ($model->description) {
                $model->description = htmlentities(htmlspecialchars($model->description));
            }
        });
        static::retrieved(function ($model) {
            if ($model->description) {
                $model->short_description = html_entity_decode(htmlspecialchars_decode($model->short_description));
            }
            if ($model->description) {
                $model->description = html_entity_decode(htmlspecialchars_decode($model->description));
            }
        });
    }
}
