<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActionUser extends Model
{
    use HasFactory;
    protected $fillable = ['id', 'action_id', 'comment', 'comment_date'];
    protected $table = 'action_users';
}
