<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;
    protected $fillable = [  
                                'path',
                                'isGood', 
                                'description',
                                'report_id',
                                'probelm_id',
                                'label_checking_id'];
    protected $table = 'images';
    
    /**
     * Get the label_cheking that owns the Image
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function label_cheking()
    {
        return $this->belongsTo(LabelChecking::class);
    }
    /**
     * Get the problem_desc that owns the Image
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function problem_desc(){
        return $this->belongsTo(ProblemDescription::class);
    }
    /**
     * Get the report that owns the Image
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function report()
    {
        return $this->belongsTo(Report::class);
    }
}
