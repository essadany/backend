<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FiveLigne extends Model
{
    use HasFactory;
    protected $fillable = [ 'five_why_id', 
                            'type','why', 
                            'answer'];
    protected $table = 'five_lignes';
    protected $enum = [
        'type'=>['occurence','detection','system']
    ];

    /**
     * Get the five_why that owns the FiveLigne
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function five_why():BelongsTo
    {
        return $this->belongsTo(FiveWhy::class);
    }
}
