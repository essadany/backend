<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class Product extends Model
{
    use HasFactory;
    protected $fillable = ['product_ref','customer_id','customer_ref','name','zone','uap'];
    protected $table = 'products';
    protected $enum = [
        'zone' =>['Salle Grise 1', 'Salle Grise 2','Salle Grise 3','Gicleur & Clapet','Fx Bobine Injection','Vanne motorisée']
    ];
    protected $attritbutes = [
        'deleted' => false
    ];
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }
    /**
     * Get the claim that owns the Product
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function claim(): BelongsTo
    {
        return $this->belongsTo(Claim::class);
    }
}



        