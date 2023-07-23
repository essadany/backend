<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $fillable = ['code','name',"info"];
    protected $table = 'customers';

    protected $attributes = [
        'deleted'=>false
    ];
   
    /**
     * Get all of the products for the Customer
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function products() : HasMany
    {
        return $this->hasMany(Product::class,'code','customer_code');
    }
}
