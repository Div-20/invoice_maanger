<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManageCurrency extends Model
{
    use HasFactory;


    const STATUS_ACTIVE = 10;
    const STATUS_INACTIVE = 5;

    public static $status_type = [
        self::STATUS_ACTIVE => 'Active',
        self::STATUS_INACTIVE => 'In Active',
    ];

    protected $fillable = ['name', 'code', 'symbol', 'thousand_separator', 'decimal_separator', 'exchange_rate', 'active'];

    // protected $casts = [
    //     'active'   => Status::class,
    //     'status' => Status::class,
    // ];

}
