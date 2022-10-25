<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function property(){
        return $this->hasMany(Property::class);
    }

    public function category(){
        return $this->hasMany(Category::class);
    }

    public function sell_item(){
        return $this->hasMany(SellItem::class);
    }

    public function supplier(){
        return $this->hasMany(Supplier::class);
    }

    public function tenant(){
        return $this->hasMany(Tenant::class);
    }

    public function purchaseDocument(){
        return $this->hasMany(PurchaseDocument::class);
    }

    public function PropertyDetail(){
        return $this->hasMany(PropertyDetail::class);
    }

    public function utilityMeter(){
        return $this->hasMany(UtilityMeter::class);
    }

    public function formula(){
        return $this->hasMany(Formula::class);
    }

    public function sellDocument(){
        return $this->hasMany(SellDocument::class);
    }
}
