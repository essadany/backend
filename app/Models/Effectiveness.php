<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Effectiveness extends Model
{
    use HasFactory;
    protected $table = 'effectivenesses';
    protected $fillable = [
        'report_id',
        'title',
        'file',
        'description'
    ];
    /**
     * Get the report that owns the Effectiveness
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function report(): BelongsTo
    {
        return $this->belongsTo(Report::class);
    }
}
