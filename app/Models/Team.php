<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\belongsToMany;

class Team extends Model
{
    use HasFactory;
    protected $fillable = ['leader'];
    protected $table = 'teams';
   
    
    public function users()
    {
        return $this->belongsToMany(User::class,'team_users');
    }
    
    public function claim()
    {
        return $this->belongsTo(Claim::class);
    }
    /**
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function meetings()
    {
        return $this->hasMany(Meeting::class);
    }
}
