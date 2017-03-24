<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\Answer;
use Input;

class AnswerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id,Request $request,Answer $answerModel,Question $questionModel)
    {
        $question=$questionModel->getQuestionById($id);
        $created=$answerModel->getAnswersByIdQuestion($id);          
        if (!isset($question)||empty($question)){
            return redirect()->to('/test');
        }
        if (isset($created) ){
            return view('answer.create',['question'=>$question,'created'=>$created]);
        }
        else
            return view('answer.create',['question'=>$question]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,Answer $answerModel)
    {
//        $this->validate($request,[
//           'answer'=>'required'
//        ]);
        $data=$request->all();
        $answer=new Answer();
        $answer->fill($data);
        $answer->save();
        $data=$answerModel->getLastAnswer();
        return response()->json(['data'=>$data]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id,Request $request,Answer $answerModel)
    {
        $answers=$answerModel->getAnswerByIdTest($id);
        return response()->json(['answers'=>$answers]);
    }


    public function answers($id,Request $request,Answer $answerModel)
    {

        //return response()->json(['id_test'=>'123']);
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
    public function update(Request $request, $id,Answer $answerModel)
    {
        $data=$request->only(['answer','iscorrect','id_test']);
        $result=$answerModel->putAnswer($data, $id);
        //$data=$answerModel->getLastAnswer();
        return response()->json(['data'=>$data]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id,Answer $answerModel)
    {
        $result=$answerModel->deleteAnswer($id);
    }
}
