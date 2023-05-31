<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'dir',
        'from',
        'to',
        'segments',
        'status',
        'body',
        'media',
        'sender_type',
        'sender_id',
        'customer_type',
        'customer_id',
        'chat_id',
    ];


    protected $dates = [
        'created_at',
        'updated_at',

    ];

    protected $appends = ['resource_url','ceo_url','support_url'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/messages/'.$this->getKey());
    }
    public function getCeoUrlAttribute()
    {   
        return url('/ceo/messages/'.$this->getKey());
    }
    public function getSupportUrlAttribute()
    {   
        return url('/support/messages/'.$this->getKey());
    }
    public function customer(): \Illuminate\Database\Eloquent\Relations\MorphTo
    {
        return $this->morphTo('customer');
    }
    public function sender(): \Illuminate\Database\Eloquent\Relations\MorphTo
    {
        return $this->morphTo('sender');
    }
    public function chat(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this -> belongsTo('App\Models\Chat','chat_id');

    }
}
