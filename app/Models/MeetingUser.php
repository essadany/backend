<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MeetingUser extends Model
{
    use HasFactory;
    protected $fillable = ['user_id',
                           'team_id',
                           'meet_id',
                           'present',
                           'comment'];
    protected $table = 'meeting_users';
}
