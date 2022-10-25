<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Document;

class PurchaseDocument extends Document
{
    use HasFactory;
    use SoftDeletes;

    public function supplier(){
        return $this->belongsTo(Supplier::class)->withTrashed();
    }
}
