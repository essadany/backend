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
}
