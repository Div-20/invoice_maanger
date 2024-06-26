<?php

namespace App\Models;

use App\Helpers\MediaHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use HasFactory;
    protected $fillable = [
        'title', 'media_type', 'alt', 'file_name', 'file_type', 'file_size', 'label',
    ];

    const CONSUMER = 1;
    const SUB_ADMIN = 2;
    const PROVIDER = 3;
    const SHOP = 4;
    const PRODUCT = 5;
    const RANDOM = 6;
    const BRAND = 7;
    const SITECONTENT = 8;
    const CATEGORIES = 9;
    const SLIDER = 10;
    const LOCATION = 11;
    const LEADS = 12;

    public static $header = [
        self::CONSUMER => 'Customer',
        self::SUB_ADMIN => 'Sub Admin',
        self::PROVIDER => 'Provider',
        self::SHOP => 'Shop',
        self::PRODUCT => 'Products',
        self::RANDOM => 'Mix',
        self::BRAND => 'Brands',
        self::SITECONTENT => 'Site Pages',
        self::CATEGORIES => 'Categories',
        self::SLIDER => 'Slider',
        self::LOCATION => 'Locations',
        self::LEADS => 'Leads',
    ];

    public static $label = [
        self::CONSUMER => 'customer',
        self::SUB_ADMIN => 'sub-admin',
        self::PROVIDER => 'provider',
        self::SHOP => 'shop',
        self::PRODUCT => 'products',
        self::RANDOM => 'mix',
        self::BRAND => 'brands',
        self::SITECONTENT => 'site-pages',
        self::CATEGORIES => 'categories',
        self::SLIDER => 'slider',
        self::LOCATION => 'locations',
        self::LEADS => 'leads',
    ];
    
    public static $directory = [
        self::CONSUMER => '/uploads/users/',
        self::SUB_ADMIN => '/uploads/users/',
        self::PROVIDER => '/uploads/users/',
        self::SHOP => '/uploads/shop/',
        self::SITECONTENT => '/uploads/sitesetting/',
        self::CATEGORIES => '/uploads/categories/',
        self::RANDOM => '/uploads/services/',
        self::SLIDER => '/uploads/slider/',
        self::BRAND => '/uploads/services/',
        self::PRODUCT => '/uploads/product/',
        self::LOCATION => '/uploads/locations/',
        self::LEADS => '/uploads/leads/',
    ];
    
    public static $folder_name = [
        self::CONSUMER => 'users',
        self::SUB_ADMIN => 'users',
        self::PROVIDER => 'users',
        self::SHOP => 'shop',
        self::SITECONTENT => 'sitesetting',
        self::CATEGORIES => 'categories',
        self::RANDOM => 'services',
        self::SLIDER => 'slider',
        self::BRAND => 'services',
        self::PRODUCT => 'product',
        self::LOCATION => 'locations',
        self::LEADS => 'leads',
    ];

    public static function boot()
    {
        parent::boot();
        static::deleting(function ($model) {
            $path = ($model->media_type) ? public_path() . self::$directory[$model->media_type] : null;
            if ($model->file_name) {
                MediaHelper::removeImage($path . $model->file_name);
            }
        });
    }

    public static $file_path;
    public function getFileNameAttribute($file_name)
    {
        if (self::$file_path) {
            return asset(self::$file_path . $file_name);
        }
        return $file_name;
    }
}
