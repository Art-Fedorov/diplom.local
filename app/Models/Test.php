<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Models\Question;
use App\Http\Controllers\Auth;
class Test extends Model
{
    protected $table='tests';
    protected $fillable=['name','id_user',
        'published_at','id_alg','maxmark','published',
        'desc','view_right_answers','shuffle_questions',
        'pass_other_questions','shuffle_answers',
        'view_more_1_answer','count_answers','count_questions','ended_at'];
    protected $guarded = ['id', '_token'];
    
    
    
    public function user()
    {
      return $this->belongsTo('App\Models\User','id_user');
    }
    public function algorithm()
    {
        return $this->belongsTo('App\Models\Algorithm','id_alg');
    }
    public function test_groups()
    {
        return $this->hasMany('App\Models\TestGroups','id_test');
    }
    public function questions()
    {
      return $this->hasMany('App\Models\Question','id_test');
    }
    public function answers()
    {
        return $this->hasMany('App\Models\Answer','id_test');
    }
    public function results()
    {
        return $this->hasMany('App\Models\Result','id_test');
    }
    public function user_test_qas()
    {
      return $this->hasMany('App\Models\UserTestQA','id_test');
    }
 
    
    
    
    
    public function getAllTests(){
        $tests=$this->with(['questions','questions.answers','test_groups','algorithm'])->get();
        return $tests;
    }
    public function getAuthTests($id){
        $tests=$this->with(['questions','questions.answers','algorithm','test_groups'])->where('id_user',$id)->get();
        return $tests;
    }
    public function getLastTest(){
        return $this->latest('id')->with(['questions','questions.answers','algorithm','test_groups'])->first();
    }
    public function getTestById($id)    {
      return $this->with(['questions','answers','questions.answers','algorithm','test_groups'])->find($id);
    }
    
    public function putTest($array,$id) {
       return $this
            ->where('id', $id)
            ->update($array);
    }
    
    public function deleteTest($id) {
       return $this
            ->where('id', $id)
            ->delete();
       
    }
    
    public function scopePublished($param) {
        $param->where('published_at','<=',Carbon::now())
                ->where('published','=',1);
    }
    public function scopeUnpublished($param) {
        $param->where('published_at','>=',Carbon::now())
                ->orWhere('published','=',0);
    }
    
}
