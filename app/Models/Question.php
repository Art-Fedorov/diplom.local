<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable=['question','id_test','weight','word'];
    protected $guarded = ['id', '_token'];
    public function test()
    {
      return $this->belongsTo('App\Models\Test','id_test');
    }
    public function answers()
    {
      return $this->hasMany('App\Models\Answer','id_question');
    }
    public function user_test_qas()
    {
      return $this->hasMany('App\Models\UserTestQA','id_question');
    }
    
    
    public function getLastQuestion(){
        return $this->latest('id')->with('answers')->with('test')->first();
    }
    public function getQuestionsByIdTest($id){
      return $this->latest('id')->where('id_test','=',$id)->with('answers')->with('test')->get()->toArray();
    }
    public function getQuestionById($id){
      return $this->with('answers')->with('test')->find($id)->toArray();
    }
    
    public function putQuestion($array,$id) {
       return $this
            ->where('id', $id)
            ->update($array);
    }
    public function deleteQuestion($id) {
       return $this
            ->where('id', $id)
            ->delete();
    }
    public function deleteQuestionsByIdTest($id) {
       return $this
            ->where('id_test', $id)
            ->delete();
    }
}
