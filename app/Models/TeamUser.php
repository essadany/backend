<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeamUser extends Model
{
    use HasFactory;
    protected $fillable=[   'user_id',
                            'team_id'];
    protected $table = 'team_users';
    protected $attributes = [
        'deleted'=>false
    ];
}
