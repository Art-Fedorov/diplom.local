<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    protected $table='results';
    protected $fillable=['percent','id_test','id_user','mark','passed'];
    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo('App\Models\User','id_user')->orderBy('id_group')->orderBy('name');
    }
    public function test()
    {
        return $this->belongsTo('App\Models\Test','id_test');
    }
    public function checkUserTest()
    {
        //return $this->belongsTo('App\Models\Test','id_test');
    }
    public function getOnlyResults(){
        return $this->orderBy('id_test', 'desc')->orderBy('id_user', 'asc')
            ->get()->toArray();
    }
    public function getAllResults(){
        return $this->with(['test','user','user.groups'])->orderBy('id_test', 'desc')->orderBy('id_user', 'asc')
            ->get()->toArray();
    }
    public function deleteResult($idU,$idT) {
        return $this
            ->where('id_test', $idT)
            ->where('id_user', $idU)
            ->delete();
    }
    public function getResultsByUser($id){
        return $this
            ->where('id_user', $id)->with(['test,user'])->get();
    }
    public function getResultsByUserTest($idUser,$idTest){
        return $this
            ->where('id_test', $idTest)->where('id_user', $idUser)->with(['test'])->first();
    }
    public function putResult($array,$idU,$idT) {
        return $this
            ->where('id_test', $idT)
            ->where('id_user',$idU)
            ->update($array);
    }
}
