<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    use HasFactory;
    protected $fillable = [  'five_why_id',
                             'type',
                             'input'];
    protected $table = 'results';
    protected $enum = [
        'type'=>['occurence','detection','system']
    ];
}
