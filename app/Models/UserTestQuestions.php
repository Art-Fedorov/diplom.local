<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserTestQuestions extends Model
{
    protected $table='user_test_questions';
    protected $fillable=['id_user','id_test','id_question'];

    public function user()
    {
        return $this->belongsTo('App\Models\User','id_user');
    }
    public function test()
    {
        return $this->belongsTo('App\Models\User','id_test');
    }
    public function question()
    {
        return $this->belongsTo('App\Models\User','id_question');
    }

    public function getQByUserTest($idU,$idT){
        return $this->where('id_user',$idU)->where('id_test',$idT)->oldest()->get()->toArray();
    }

    public function deleteQuestions($idU,$idT) {
        return $this
            ->where('id_user',$idU)->where('id_test',$idT)->delete();
    }
}
