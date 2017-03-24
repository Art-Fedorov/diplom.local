<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    protected $fillable=['answer','iscorrect','id_question','id_test'];
    public function user_test_qas()
    {
      return $this->hasMany('App\Models\UserTestQA');
    }
    public function question()
    {
      return $this->belongsTo('App\Models\Question','id_question');
    }
    public function test()
    {
        return $this->belongsTo('App\Models\Test','id_test');
    }
    public function getAnswersByIdQuestion($id){
      return $this->latest('id')->where('id_question',$id)->get();
    }
    public function getLastAnswer(){
        return $this->latest('id')->first();
    }
    public function getAnswerById($id){
      return $this->find($id)->toArray();
    }
    public function getAnswerByIdTest($id){
        return $this->where('id_test',$id)->get()->toArray();
    }
    public function putAnswer($array,$id) {
       return $this
            ->where('id', $id)
            ->update($array);
    }
    public function deleteAnswer($id) {
       return $this
            ->where('id', $id)
            ->delete();
    }
}
