<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Action extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','action', 'planned_date', 'start_date', 'status', 'done_date'];
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

    /**
     * Get the report that owns the Action
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function report(): BelongsTo
    {
        return $this->belongsTo(Report::class);
    }
}
