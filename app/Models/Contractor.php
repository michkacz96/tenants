<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

abstract class Contractor extends Model
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
        if($this->country !== NULL){
            $address = $address.', '.$this->country;
        }
        return $address;
    }

    public function getAddress(){
        if($this->getCityAddress() !== NULL){
            return $this->getFullStreet().', '.$this->getCityAddress();
        } else{
            return $this->getFullStreet();
        }
        
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
