<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\belongsToMany;
class LabelChecking extends Model
{
    use HasFactory;
    protected $fillable = [
                            'sorting_method',
                            'bontaz_plant'];
    protected $table = 'label_checkings';
    protected $enum = [
        'bontaz_plant'=>['El Jadia','Shanghai','Marnaz','Fouchana', 'Velka Dobra','Viana Do Casteo','Troy','Pingamonhangaba-sp']
    ];

    public function claim()
    {
        return $this->belongsTo(Claim::class);
    }
}
