<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\hasOne;

class Claim extends Model
{
    use HasFactory;
    protected $fillable = ['internal_ID','refRecClient','category','customer_part_number','product_ref', 'status','engraving', 'prod_date', 'object', 
    'opening_date', 'customer', 'claim_details', 'def_mode',
    'nbr_claimed_parts'];
    protected $enum = [
        'status' => ['on going', 'done','delayed'],
        'category'=> ['AQI', 'CC','Field']
    ];
    protected $attributes = [
        'status' => 'on going',
        'deleted'=>false
    ];
    protected $table = 'claims';

    
    public function team()
    {
        return $this->hasOne(Team::class);
    }
    public function report()
    {
        return $this->hasOne(Report::class);
    }
    public function prob_desc()
    {
        return $this->hasOne(ProblemDescription::class);
    }
    public function containement()
    {
        return $this->hasOne(Containement::class);
    }
    public function ishikawa()
    {
        return $this->hasOne(Ishikawa::class);
    }
    public function five_why()
    {
        return $this->hasOne(FiveWhy::class);
    }
    public function label_checking()
    {
        return $this->hasOne(LabelChecking::class);
    }
    
    /**
     * Get the product associated with the Claim
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function product(): HasOne
    {
        return $this->hasOne(Product::class, 'product_ref', 'product_ref');
    }
}