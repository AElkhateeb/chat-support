<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{

    protected $fillable = [
        'phone',
        'name',
        'lang',
        'opened',
    
    ];
    
    
    protected $dates = [
        'created_at',
        'updated_at',
    
    ];
    
    protected $appends = ['resource_url','ceo_url','support_url'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {   
        return url('/admin/customers/'.$this->getKey());
    }
    public function getCeoUrlAttribute()
    {   
        return url('/ceo/customers/'.$this->getKey());
    }
    public function getSupportUrlAttribute()
    {   
        return url('/support/customers/'.$this->getKey());
    }
    public function chats(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany('App\Models\Chat', 'customer');
    }
    public function teamLeaderAdmins(): \Illuminate\Database\Eloquent\Relations\MorphToMany
    {
        return $this->morphedByMany('App\Models\Users\TeamLeaderAdmin' ,'chat');
    }
    public function supportAdmins(): \Illuminate\Database\Eloquent\Relations\MorphToMany
    {
        return $this->morphedByMany('App\Models\Users\SupportAdmin' ,'chat');
    }

    public function supervisorAdmins(): \Illuminate\Database\Eloquent\Relations\MorphToMany
    {
        return $this->morphedByMany('App\Models\Users\SupervisorAdmin' ,'chat');
    }
    public function ceoAdmins(): \Illuminate\Database\Eloquent\Relations\MorphToMany
    {
        return $this->morphedByMany('App\Models\Users\CeoAdmin' ,'chat');
    }
    public function admins(): \Illuminate\Database\Eloquent\Relations\MorphToMany
    {
        return $this->morphedByMany( 'Brackets\AdminAuth\Models\AdminUser' ,'chat');
    }
}
