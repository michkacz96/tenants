<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected static $cat_types = [
        0 => 'Sales', 
        1 => 'Purchases'
    ];

    public static function getCatType(){
        return self::$cat_types;
    }

    public function sell_item(){
        return $this->hasMany(SellItem::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
