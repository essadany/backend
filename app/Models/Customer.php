<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $fillable = ['customer_ref','name','category',"info"];
    protected $table = 'customers';
    protected $enum = [
        'category' => ['Intern', 'Extern']
    ];
   
}
