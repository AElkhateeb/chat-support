<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    
    protected $fillable = [
        'customer_type',
        'customer_id',
        'sender_type',
        'sender_id',
        'body',
    ];


    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $appends = ['resource_url','ceo_url','support_url','opened_chat'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
      
        return url('/admin/chats/'.$this->getKey());
    }
    public function getCeoUrlAttribute()
    {   
        return url('/ceo/chats/'.$this->getKey());
    }
    public function getSupportUrlAttribute()
    {   
        return url('/support/chats/'.$this->getKey());
    }
     public function customer(): \Illuminate\Database\Eloquent\Relations\MorphTo
    {
        return $this->morphTo('customer');
    }
    public function sender(): \Illuminate\Database\Eloquent\Relations\MorphTo
    {
        return $this->morphTo('sender');
    }
    public function Messages(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany('App\Models\Message','chat_id');

    }
    public function getOpenedChatAttribute(){
        
        $customer=$this->customer->where('opened',1)->get();
        if($customer){
           return $customer->makeHidden(['created_at','updated_at','resource_url','ceo_url','support_url'])->toArray(); 
       }else{
            return [];
       }
       
    }

}