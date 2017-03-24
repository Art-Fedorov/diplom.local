<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    public function user_test_qas()
    {
      return $this->hasMany('App\Models\UserTestQA','id_user');
    }
    public function tests()
    {
      return $this->hasMany('App\Models\Test','id_user');
    }
    public function groups()
    {
        return $this->belongsTo('App\Models\Group','id_group');
    }
    public function results()
    {
        return $this->hasMany('App\Models\Result','id_user');
    }
    public function getUserById($id)    {
        return $this->find($id);
    }
    public function getUsers()    {
        return $this->get()->toArray();
    }
    public function putUser($array,$id) {
        return $this
            ->where('id', $id)
            ->update($array);
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'id_group'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    
}
