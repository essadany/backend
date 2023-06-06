<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['product_ref','customer_id','customer_ref','name','zone','uap'];
    protected $table = 'products';
    protected $enum = [
        'zone' => ['Module', 'Bobine','Faiscaux','Clapet','Gicleur','Vanne']
    ];
    
    
}



        