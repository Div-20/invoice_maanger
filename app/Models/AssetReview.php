<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetReview extends Model
{
    use HasFactory;
    protected $table = 'asset_review';
    protected $fillable = [
        'id','asset_id', 'user_id', 'review', 'status'
    ];
    public function user(){
        return $this->hasOne(User::class, 'id', 'user_id');
    }
    public function asset(){
        return $this->hasOne(Asset::class, 'id', 'asset_id');
    }
}
