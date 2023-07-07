<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;
     protected $fillable = ['title','description','action_id', 'user_id',
     'message',
     'notification_date',
     'read_at'];
     protected $table = 'notifications';

     /**
      * Get the user that owns the Notification
      *
      * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
      */
     public function user()
     {
         return $this->belongsTo(User::class);
     }
}
