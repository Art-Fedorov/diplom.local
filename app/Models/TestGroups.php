<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TestGroups extends Model
{
    protected $table='test_groups';
    protected $fillable=['id_test','id_group'];
    public function test()
    {
        return $this->belongsTo('App\Models\Test','id_test');
    }
    public function question()
    {
        return $this->belongsTo('App\Models\Group','id_group');
    }

    public function getGroupsByTest($id){
        return $this
            ->where('id_test', $id)->get()->toArray();
    }

    public function deleteGroupsByTest($id) {
        return $this
            ->where('id_test', $id)
            ->delete();
    }
}
