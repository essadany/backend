<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Observers\ActionObserver;

class Action extends Model
{
    use HasFactory;

    protected $fillable = ['report_id', 'user_id','action','type', 'status','planned_date', 'start_date', 'done_date'];
    protected $enum = [
        'type' => ['containment','potential','implemented','preventive'],
        'status' => ['not started','on going', 'done','delayed']
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

    /**
     * Get all of the comments for the Action
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany(ActionComment::class);
    }

    protected static function boot()
    {
        parent::boot();
        self::observe(ActionObserver::class);
    }
}
