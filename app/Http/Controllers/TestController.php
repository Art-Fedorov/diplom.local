<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Test;
use Carbon\Carbon;
use Auth;
use Input;
use Illuminate\Support\Facades\Route;

class TestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request,Test $testModel)
    {
        $data = $request->all();
        if (!isset($data['id_user'])){
            $tests=$testModel->getAllTests();
            return response()->json(['tests'=>$tests]);
        }
        else {
            $tests=$testModel->getAuthTests($data['id_user']);
            return response()->json(['tests'=>$tests]);
        }
        //dump($data);
        //return response()->json(['tests'=>$tests,'req'=>Auth::id()]);
    }
    public function tests(Test $testModel)
    {
        
    }
    public function unpublished(Test $testModel)
    {
        $tests=$testModel->getUnpublishedTests();
        return view('test.index',['tests'=>$tests]);
    }
    public function published(Test $testModel)
    {
        $tests=$testModel->getPublishedTests();
        return view('test.index',['tests'=>$tests]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('test.create',
                [
                   
                ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,Test $testModel)
    {
        $data=Input::except(['id']);
        $test=new Test();
        $testModel->insert($data);
        $data=$testModel->getLastTest();
        return response()->json(['data'=>$data]) ;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, Test $testModel)
    {
        $test=$testModel->getTestById($id);
        return response()->json(['test'=>$test]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Test $testModel, Request $request)
    {
        $test=$testModel->getTestById($id);
        return response()->json(['edited'=>$test]);      
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id, Test $testModel)
    {
        $array = Input::except(['_method', '_token','id_alg']);

        $result=$testModel->putTest($array, $id);
        $data=$testModel->getTestById($id);
        return response()->json(['data'=>$data]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Test $testModel)
    {
        $result=$testModel->deleteTest($id);
    }
}
