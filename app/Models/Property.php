<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Property extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function getFullStreet(){
        $full_address = $this->street_name.' '.$this->street_number;
        if($this->apt_number !== NULL){
            $full_address = $full_address.'/'.$this->apt_number;
        }
        return $full_address;
    }

    public function getCityAddress(){
        $address = $this->zip_code.' '.$this->city;
        if($this->state !== NULL){
            $address = $address.', '.$this->state;
        }
        return $address;
    }

    public function getAddress(){
        return $this->getFullStreet().', '.$this->getCityAddress();
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    // public function distinctPropertyDetails(){
    //     return $this->belongsToMany(PropertyDetail::class)->withPivot('quantity')->withPivot('detail_start_date')->withPivot('detail_end_date')->orderBy('name')->orderBy('detail_start_date')->distinct('property_detail_id');
    // }

    public function propertyDetails(){
        return $this->belongsToMany(PropertyDetail::class)->withPivot('id')->withPivot('quantity')->withPivot('detail_start_date')->withPivot('detail_end_date')->orderBy('name')->orderBy('detail_start_date');
    }

    public function tenants(){
        return $this->belongsToMany(Tenant::class)->withPivot('id')->withPivot('start_rent_date')->withPivot('end_rent_date')->orderBy('start_rent_date');
    }

    public function sellitems(){
        return $this->belongsToMany(SellItem::class)->withPivot('id')->withPivot('start_date')->withPivot('end_date')->withPivot('formula_id')->withPivot('price');
    }
}