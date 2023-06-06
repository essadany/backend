<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Annexe extends Model
{
    use HasFactory;
    protected $table = 'annexes';
    protected $fillable = [
        'report_id'
    ];
}
