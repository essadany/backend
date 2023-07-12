<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\belongsToMany;
class ProblemDescription extends Model
{
    use HasFactory;
    protected $fillable = [
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
    protected $enum = [
        'bontaz_fault'=>['YES','NO','NOT CONFIRMED']
    ];
    protected $attributes = [
        'recurrence' => false,
        'received'=>false,
        'bontaz_fault'=>'NOT CONFIRMED'
        
    ];

    public function claim()
    {
        return $this->belongsTo(Claim::class);
    }
    /**
     * Get all of the images for the ProblemDescription
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function images()
    {
        return $this->hasMany(Image::class,'problem_id','id');
    }
   
}
