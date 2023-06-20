<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\belongsToMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FiveWhy extends Model
{
    use HasFactory;
    protected $fillable = ['claim_id'];
    protected $table = 'five_whys';

    public function claim()
    {
        return $this->belongsTo(Claim::class);
    }
    /**
     * Get all of the results for the FiveWhy
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function results()
    {
        return $this->hasMany(Result::class);
    }
    /**
     * Get all of the five_lignes for the FiveWhy
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function five_lignes()
    {
        return $this->hasMany(FiveLigne::class);
    }
}
