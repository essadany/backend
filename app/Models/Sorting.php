<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sorting extends Model
{
    use HasFactory;
    protected $table = 'sortings';
    protected $fillable = [
        'containement_id',
        'location_company',
        'qty_to_sort',
        'qty_sorted',
        'qty_NOK',
        'scrap'
    ];

    /**
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(Containement::class);
    }
}
