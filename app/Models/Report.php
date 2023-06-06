<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
