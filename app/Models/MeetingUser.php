<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MeetingUser extends Model
{
    use HasFactory;
    protected $fillable = ['user_id',
                           'meeting_id'];
    protected $table = 'meeting_users';
   
}
