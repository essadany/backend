<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Containement extends Model
{
    use HasFactory;
    protected $fillable = [
        'report_id',
        'method_description',
        'method_validation',
        'risk_assesment',
    ];
    protected $table = "containements";
}
