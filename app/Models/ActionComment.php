<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActionComment extends Model
{
    use HasFactory;
    protected $fillable = ['id', 'action_id', 'comment', 'comment_date'];
    protected $table = 'action_comments';

    /**
     * Get the action that owns the ActionComment
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function action()
    {
        return $this->belongsTo(Action::class);
    }
}
