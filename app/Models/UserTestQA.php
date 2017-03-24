<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserTestQA extends Model
{
    protected $table='user_test_qas';
    protected $fillable=['id_user','id_test','id_question','id_answer','answer'];
    public function user()
    {
      return $this->belongsTo('App\Models\User','id_user');
    }
    public function test()
    {
      return $this->belongsTo('App\Models\Test','id_test');
    }
    public function question()
    {
      return $this->belongsTo('App\Models\Question','id_question');
    }
    public function answer()
    {
      return $this->belongsTo('App\Models\Answer','id_answer');
    }
    public function getQAByUserTest($idU,$idT){
        return $this->where('id_user',$idU)->where('id_test',$idT)->oldest()->get();
    }

    public function deleteItem($idU,$idT) {
        return $this
            ->where('id_user',$idU)->where('id_test',$idT)->delete();
    }
}
