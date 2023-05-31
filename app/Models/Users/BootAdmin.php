<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Model;
use App\Models\Income;
class BootAdmin extends Model
{
    protected $fillable = [
        'pattern',
        'stuff',
        'previous',
        'checked',
    ];
    
    
    protected $dates = [
        'created_at',
        'updated_at',
    
    ];
    
    protected $appends = ['resource_url','ceo_url','support_url','boot_replay','last_replay'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
       
        return url('/admin/boot-admins/'.$this->getKey());
    }
    public function getCeoUrlAttribute()
    {   
        return url('/ceo/boot-admins/'.$this->getKey());
    }
    public function getSupportUrlAttribute()
    {   
        return url('/support/boot-admins/'.$this->getKey());
    }
    
    public function chats(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany('App\Models\Chat', 'customer');
    }
    public function message(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany('App\Models\Message','sender');
    }
    public function customers(): \Illuminate\Database\Eloquent\Relations\MorphToMany
    {
        return $this->morphToMany('App\Models\Customer', 'chat');
    }
    public function incomes()
    {
         return $this->hasMany('App\Models\Income','pattern_id','id');
    }
    public function replies()
    {
         return $this->hasMany('App\Models\Reply','pattern_id','id');
    }
     public function previous() {
        return $this->belongsTo('App\Models\Users\BootAdmin','previous');
    }
    public function getBootReplayAttribute(){
        
        $incomes=$this->incomes;
        if($incomes){
           return $incomes->makeHidden(['created_at','updated_at','resource_url','ceo_url','support_url','replay'])->toArray();
       }else{
            return [];
       }
       
    }
    public function getLastReplayAttribute(){
        
        $replay=$this->replies;
      
        if($replay){
           return $replay->makeHidden(['created_at','updated_at','resource_url','ceo_url','support_url'])->toArray();
       }else{
            return [];
       }
    }
}
