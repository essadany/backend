<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\belongsToMany;
class LabelChecking extends Model
{
    use HasFactory;
    protected $fillable = [ 'claim_id',
                            'sorting_method',
                            'bontaz_plant'];
    protected $table = 'label_checkings';
    protected $enum = [
        'bontaz_plant'=>['Morocco','France','Italy','Germany', 'Poland','China','Mexico','Tunisia']
    ];

    public function claim()
    {
        return $this->belongsTo(Claim::class);
    }
    /**
     * Get the image associated with the LabelChecking
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function image()
    {
        return $this->hasOne(Image::class);
    }
}
