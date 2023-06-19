<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\belongsToMany;
class Report extends Model
{
    use HasFactory;
    protected $table = 'reports';
    protected $fillable = ['report_ref',
    'due_date',
    'sub_date',
    'contianement_actions',
    'first_batch3',
    'first_batch6',
    'date_cause_definition',
    'reported_by',
    'pilot',
    'ddm',
    'approved',
    'others',
    'ctrl_plan',
    'pfmea',
    'dfmea',
    'progress_rate'];

    public function claim()
    {
        return $this->belongsTo(Claim::class);
    }

    /**
     * Get all of the actions for the Report
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function actions()
    {
        return $this->hasMany(Action::class);
    }
}
