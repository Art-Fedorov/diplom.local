<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserTestAnswers extends Model
{
    protected $table='user_test_answers';
    protected $fillable=['id_user','id_test','id_answer'];

    public function user()
    {
        return $this->belongsTo('App\Models\User','id_user');
    }
    public function test()
    {
        return $this->belongsTo('App\Models\User','id_test');
    }
    public function answer()
    {
        return $this->belongsTo('App\Models\User','id_answer');
    }

    public function getAByUserTest($idU,$idT){
        return $this->where('id_user',$idU)->where('id_test',$idT)->oldest()->get()->toArray();
    }

    public function deleteAnswers($idU,$idT) {
        return $this
            ->where('id_user',$idU)->where('id_test',$idT)->delete();
    }
}
