<?php
namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Brackets\Translatable\Traits\HasTranslations;

class Income extends Model
{
use HasTranslations;
    protected $fillable = [
        'income',
        'pattern_id',
        'replay_id',
    ];
    
    
    protected $dates = [
        'created_at',
        'updated_at',
    ];
    // these attributes are translatable
    public $translatable = [
        'income',
    ];
    
    protected $appends = ['resource_url','ceo_url','support_url','income_replay'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/incomes/'.$this->getKey());
    }
    public function getCeoUrlAttribute()
    {   
        return url('/ceo/incomes/'.$this->getKey());
    }
    public function getSupportUrlAttribute()
    {   
        return url('/support/incomes/'.$this->getKey());
    }

     public function pattern() {
        return $this->belongsTo('App\Models\Users\BootAdmin','pattern_id');
    }
    public function replay() {
        return $this->belongsTo('App\Models\Reply','replay_id');
    }
    public function getIncomeReplayAttribute(){
        
        $replay= $this->replay;
        if($replay){
           return $replay->makeHidden(['created_at','updated_at','resource_url','ceo_url','support_url','replay'])->toArray(); 
       }else{
            return [];
       }
       
    }
    
}
