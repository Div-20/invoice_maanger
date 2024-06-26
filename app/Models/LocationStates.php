<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LocationStates extends Model
{
    use HasFactory;

    const STATUS_ACTIVE = 10;
    const STATUS_INACTIVE = 5;

    protected $fillable = [
        'name', 'country_id', 'status'
    ];

    public function cities()
    {
        return $this->hasMany(LocationCity::class, 'state_id', 'id');
    }
}
