<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PPM extends Model
{
    use HasFactory;
    protected $fillable = ['year','month','week','shipped_parts','objectif'];
    protected $table = 'ppm';
    protected $attributes=[
        'objectif'=>3
    ];
}

