<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LocationCountry extends Model
{
    use HasFactory;

    const STATUS_ACTIVE = 10;
    const STATUS_INACTIVE = 5;

    protected $fillable = ['name', 'code', 'capital', 'currency', 'status'];
}
