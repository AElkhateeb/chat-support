<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Brackets\Translatable\Traits\HasTranslations;

class Reply extends Model
{
use HasTranslations;
    protected $fillable = [
        'replay',
        'pattern_id',
    
    ];
    
    
    protected $dates = [
        'created_at',
        'updated_at',
    
    ];
    // these attributes are translatable
    public $translatable = [
        'replay',
    
    ];
    
    protected $appends = ['resource_url','ceo_url','support_url'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
       
        return url('/admin/replies/'.$this->getKey());
    }
    public function getCeoUrlAttribute()
    {   
        return url('/ceo/replies/'.$this->getKey());
    }
    public function getSupportUrlAttribute()
    {   
        return url('/support/replies/'.$this->getKey());
    }
    public function pattern() {

        return $this->belongsTo('App\Models\Users\BootAdmin','pattern_id','id');
    }
}
