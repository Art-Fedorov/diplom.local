<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Algorithm extends Model
{
    protected $fillable=['name','desc'];
    public function getAlgorithms(){
        return $this->get()->toArray();
    }
}
