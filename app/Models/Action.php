<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Action extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','action', 'pilot', 'planned_date', 'start_date', 'status', 'done_date'];
    protected $enum = [
        'type' => ['containment','potential','implemented','preventive'],
        'status' => ['not started','on going', 'done']
    ];
    protected $attributes = [
        'type' => 'containment',
        'status' => 'not started',
        'deleted'=>false
    ];
    protected $table = 'actions';
}
