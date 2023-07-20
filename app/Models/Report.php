<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\belongsToMany;
class Report extends Model
{
    use HasFactory;
    protected $table = 'reports';
    protected $fillable = [
    'due_date',
    'sub_date',
    'containement_actions',
    'first_batch3',
    'first_batch6',
    'date_cause_definition',
    'reported_by',
    'pilot',
    'ddm',
    'approved',
    'others',
    'ctrl_plan',
    'pfmea',
    'dfmea',
    'status',
    'progress_rate'];
    protected $enum = [
        'status' => ['Submitted','On going', 'No 8D Required'],
        'category'=> ['AQI', 'CC','Field'],
        
    ];
    protected $attributes = [
        'status' => 'On going',
        'progress_rate'=>'0%'    ];
    public function claim()
    {
        return $this->belongsTo(Claim::class);
    }

    /**
     * Get all of the actions for the Report
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function actions()
    {
        return $this->hasMany(Action::class);
    }
    /**
     * Get the effectiveness associated with the Report
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
   
    public function effectiveness()
    {
        return $this->hasOne(Effectiveness::class);
    }
    /**
     * Get all of the images for the Report
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function images()
    {
        return $this->hasMany(Image::class);
    }
    
}
