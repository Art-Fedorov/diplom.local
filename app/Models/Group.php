<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Group extends Model
{
    public $timestamps = false;
    protected $fillable=['group','desc','start_year','end_year'];
    public function getActiveGroups(){
        //Carbon::now()->diffInSeconds(Carbon::parse($request->session()->get('date_start_passing'.$id)));
        $groups=$this->whereDate('start_year','<=',date('Y-m-d'))
            ->whereDate('end_year','>=',date('Y-m-d'))->get()->toArray();
        return $groups;
    }
    public function getGroups(){
        //Carbon::now()->diffInSeconds(Carbon::parse($request->session()->get('date_start_passing'.$id)));
        $groups=$this->orderBy('group','desc')->get()->toArray();
        return $groups;
    }
    public function getGroupById($id){
        //Carbon::now()->diffInSeconds(Carbon::parse($request->session()->get('date_start_passing'.$id)));
        $groups=$this->where('id',$id)->get()->toArray();
        return $groups;
    }
    public function putGroup($array,$id) {
        return $this
            ->where('id', $id)
            ->update($array);
    }
}
