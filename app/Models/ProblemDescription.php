<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\belongsToMany;
class ProblemDescription extends Model
{
    use HasFactory;
    protected $fillable = ['claim_id',
                            'what',
                            'where',
                            'who',
                            'when',
                            'why',
                            'how',
                            'how_many_before',
                            'how_many_after',
                            'recurrence',
                            'received',
                            'date_reception',
                            'date_done',
                            'bontaz_fault',
                            'description'      
];
    protected $table = 'problem_descriptions';

    public function claim()
    {
        return $this->belongsTo(Claim::class);
    }
}
