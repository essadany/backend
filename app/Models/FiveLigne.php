<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FiveLigne extends Model
{
    use HasFactory;
    protected $fillable = [ 'five_why_id', 
                            'type','why', 
                            'answer'];
    protected $table = 'five_lignes';
    protected $enum = [
        'type'=>['occurence','detection','system']
    ];
}
