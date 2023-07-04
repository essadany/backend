<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\belongsToMany;
class Ishikawa extends Model
{
    use HasFactory;
    protected $fillable = ['claim_id'];
    protected $table = 'ishikawas';

    public function claim()
    {
        return $this->belongsTo(Claim::class);
    }
    /**
     * Get all of the categories for the Ishikawa
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function categories()
    {
        return $this->hasMany(Category::class);
    }
}
