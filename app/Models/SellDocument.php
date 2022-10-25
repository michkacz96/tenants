<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Document;

class SellDocument extends Document
{
    use HasFactory;
    use SoftDeletes;

    public function tenant(){
        return $this->belongsTo(Tenant::class)->withTrashed();
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
