<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    
    protected $fillable = ['ishikawa_id',
                            'type',
                            'input',
                            'isPrincipale',
                            'status',
                            'influence',
                            'comment'];
    protected $table = 'categories';
    protected $enum = [
        'type'=>['Person','Machine','Materials','Method', 'Management', 'Measurment', 'Environment', 'Money'],
        'status'=>['on going','confirmed','not confirmed']
    ];
    protected $attributes = [
        'isPrincipale' => false
    ];
}
