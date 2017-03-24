<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\Test;
use Input;


class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('question.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
//    public function create($id,Request $request,Test $testModel,Question $questionModel)
//    {
//        $test=$testModel->getTestById($id);
//        $created=$questionModel->getQuestionsByIdTest($id);          
//        if (!isset($test)||empty($test)){
//            return redirect()->to('test/create');
//        }
//        if (isset($created) )
//            return view('question.create',['test'=>$test,'created'=>$created]);
//        else
//            return view('question.create',['test'=>$test]);
//    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,Question $questionModel)
    {
        $data=$request->all();
        $question=new Question();
        $question->fill($data);
        $question->save();
        $data=$questionModel->getLastQuestion();
        return response()->json(['data'=>$data]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
//    public function show($id,Question $questionModel)
//    {
//        $data=$questionModel->getQuestionById($id);
//        //dd($data);
//        return response()->json($data);
//    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id,Request $request,Question $questionModel,Test $testModel)
    {
        $question=$questionModel->getQuestionById($id);
        $created=$questionModel->getQuestionsByIdTest($question['id_test']);
        $test=$testModel->getTestById($question['id_test']);
        return response()->json(['edited'=>$question,'created'=>$created,'test'=>$test]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id,Question $questionModel)
    {
        $data=$request->except(['id_test','id']);
        $result=$questionModel->putQuestion($data, $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id,Question $questionModel)
    {
        $result=$questionModel->deleteQuestion($id);
    }
}
