<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AutoIncrement extends Model
{
    use HasFactory;

    protected $fillable = [
        'auto_user', 'auto_cart', 'auto_product', 'auto_order', 'auto_sub_admin', 'auto_category', 'auto_brand', 'auto_transaction', 'auto_leads',
    ];

    public static function getAutoIncrementId($column)
    {
        if (in_array($column, (new self)->fillable)) {
            $auto_inc = self::select($column)->first();
            self::select($column)->increment($column, 1);
            return $auto_inc->{$column};
        }
        return NULL;
    }
}
