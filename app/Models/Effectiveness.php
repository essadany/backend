<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Effectiveness extends Model
{
    use HasFactory;
    protected $table = 'effectivenesses';
    protected $fillable = [
        'report_id',
        'title',
        'file',
        'description'
    ];
}
