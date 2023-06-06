<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;
    protected $fillable = [     'name',
                                'type',
                                'bloob',  
                                'isGood', 
                                'description',
                                'report_id',
                                'annexe_id',
                                'label_check_id'];
    protected $table = 'images';
}
