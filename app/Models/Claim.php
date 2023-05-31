<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Claim extends Model
{
    protected $fillable = ['internal_ID','refRecClient','product_ref', 'engraving', 'prod_date', 'object', 
    'opening_date', 'final_cusomer', 'claim_details', 'def_mode',
    'nbr_claimed_parts', 'returned_parts'];
    
    protected $table = 'claims';
    use HasFactory;
    
}