<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Contractor;

class Tenant extends Contractor
{
    use HasFactory;
    use SoftDeletes;

    public function properties(){
        return $this->belongsToMany(Property::class)->withPivot('id')->withPivot('start_rent_date')->withPivot('end_rent_date')->orderByDesc('end_rent_date');
    }

    public function sellDocument(){
        return $this->hasMany(SellDocument::class);
    }
}
