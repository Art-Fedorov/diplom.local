<?php

namespace App\Http\Controllers;
use App\Models\Test;
use App\Models\Question;
use App\Models\Answer;
use App\Models\User;
use App\Models\UserTestQA;
use Illuminate\Http\Request;
use DB;
use App\Quotation;

class UserTestQAController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, UserTestQA $testQA)
    {
        $data=\Input::all();
        //$request->session()->put('questionsAnswers'.$data['id_test'],$data);
        $data['created_at']= \Carbon\Carbon::now()->toDateTimeString();
        $data['updated_at']= \Carbon\Carbon::now()->toDateTimeString();

    //        DB::table('user_test_qas') -> insert($data);
        //$testQA->fill($data1)->save();
        //return($data);
        //$testQA=new UserTestQA();
        $testQA->fill($data)->save();
        return response()->json($data) ;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id,UserTestQA $testQA)
    {
        $result=$testQA->deleteTest($id);
    }
}
