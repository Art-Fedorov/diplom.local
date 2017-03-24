<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\UserTestQA;
use App\Models\Test;
use App\Models\Result;
use App\Models\Question;
use Illuminate\Http\Request;
use App\Models\UserTestQuestions;
use App\Models\UserTestAnswers;
use Auth;

class ResultController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Result $rc)
    {
        $data= $rc->getResultsByUser(Auth::id());
        return response()->json(['results'=>$data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,Result $resultModel, UserTestQA $testQA,Test $testModel)
    {

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
    public function update($id,Request $request,Result $resultModel, UserTestQA $testQA,
                           Test $testModel,Answer $answerModel,Question $questionModel,
                           UserTestAnswers $utaModel, UserTestQuestions $utqModel)
    {
        $data=$request->all();
        $data=json_decode($data['data'],true);
        $request->session()->forget('date_start_passing'.$data['id_test']);
        //$request->session()->forget('questionsAnswers'.$data['id_test']);
        $idU=Auth::id();
        $idT=$id;
        $idAlg=$data['id_alg'];

        //Если тест уже был пройден, то на эту страницу доступ запрещен
        $results=$resultModel->getResultsByUserTest($idU,$idT);
        //if ($results['passed']) return redirect('/pass');

        //Добавляем тест в категорию тех, которые уже пройдены
        $test = $testModel->getTestById($idT)->toArray();
        //$testModel->where('id',$id)->update(['archive'=>true]);
        //переменная для удобства
        $questions = $test['questions'];


        if ($idAlg==1) {
            $qa=$testQA->getQAByUserTest($idU,$idT);
            $questionsAnswers=[];
            //Преобразование массива из данных таблицы

            //Текущий вопрос в составлении нового массива (куда добавлять вопросы)
            $currentQ=null;
            //Индекс вопроса
            $counter=-1;
            foreach($qa as $k=>$item){
                $currentCounter=0;
                if ($item['answer']!=null){
                    $questionsAnswers[]=[
                        'id_question'=>  $item['id_question'],
                        'answers'=>[$currentCounter=>['id_answer'=>$item['id_answer'],'answer'=>$item['answer']]],
                    ];
                    $counter++;
                    continue;
                }
                if($currentQ!=$item['id_question']){
                    $currentQ=$item['id_question'];
                    $questionsAnswers[]=[
                      'id_question'=>  $item['id_question'],
                      'answers'=>[$currentCounter++=>['id_answer'=>$item['id_answer']]]
                    ];
                    $counter++;
                } else {
                    $questionsAnswers[$counter]['answers'][]=['id_answer'=>$item['id_answer']];
                }
            }


            //Все ответы на вопросы пользователя
            $countRight = 0;
            foreach ($questionsAnswers as $key=>$item){
                $indexQuestion=ResultController::getArrayIndex($questions,'id',$item['id_question']);

                //ответы на вопросы из теста
                $answers=$questions[$indexQuestion]['answers'];

                //Переменная для проверки правильности всего ответа
                $flag=true;

                //Если ответ типа слово/число
                if (array_key_exists('answer',$item['answers'][0])){
                    //Если ответ верен
                    if (strtolower($item['answers'][0]['answer'])==strtolower($questions[$indexQuestion]['answers'][0]['answer'])){
                        $questionsAnswers[$key]['answers'][0]['iscorrect']=true;
                    //Если ответ неверен
                    } else {
                        $questionsAnswers[$key]['answers'][0]['iscorrect']=false;
                        $flag=false;
                    }
                }
                else {
                    foreach ($item['answers'] as $k=>$idAnswer){
                        //берем индекс вопроса
                        $indexAnswer=ResultController::getArrayIndex($answers,'id',$idAnswer['id_answer']);
                        //Если вопрос со взятым индексом неверен, то помечаем это
                        if (!$answers[$indexAnswer]['iscorrect']) {
                        $flag=false;
                        //Если верен то помечаем что верен
                        } else {
                            $questionsAnswers[$key]['answers'][$k]['iscorrect']=true;
                        }
                    }
                    foreach($answers as $k=>$answer){
                        if ($answer['iscorrect']) {
                            $x = array_search($answer['id'], array_column($item['answers'], 'id_answer'));
                            if ($x===false) $flag=false;
                        }

                    }
                }

                if ($flag) $countRight++;
                $questionsAnswers[$key]['iscorrect']=$flag?true:false;
            }
            //Имеем на выходе массив с верными и неверными ответами,
            //однако если пользователь не отвечал на какие-то
            //вопросы, то это не отображается. Массив состоит из стольких
            //элементов, на сколько ответил пользователь

            $result = ['id_test' => $data['id_test'], 'id_user' => Auth::id(),
                'percent' => 0, 'mark' => 0, 'right'=>$countRight, 'all'=>0,'allWeight'=>0,'weight'=>0];

            //формирование массива для предоставления правильных/неправильных ответов

            //проход по вопросам теста
            foreach ($test['questions'] as $key=>$question){
                $test['questions'][$key]['weightAnswer']=0;
                $countRightAnswers=0;
                $countUserRightAnswers=0;
                //Находим индекс текущего вопроса в массиве ответов пользователей
                $curQ=ResultController::getArrayIndex($questionsAnswers,'id_question',$question['id']);
                //Проход по всем ответам внутри вопроса
//                if ($question['word']) {
//                    $userAnswer=
//                }
                foreach ($test['questions'][$key]['answers'] as $k => $answer) {
                    //Флаг для пометки требовалось поставить
                    $f=false;

                    //вес ответа в вопросе
                    if($answer['iscorrect']) $countRightAnswers++;

                    //Если пользователь дал ответ на текущий вопрос
                    if ($curQ>-1) {
                        //Проход по ответам данным пользователем
                        foreach ($questionsAnswers[$curQ]['answers'] as $kq => $answerq) {
                            //Если перебор наткнулся на одинаковые id вопроса
                            if ($answer['id'] == $answerq['id_answer']){
                                //если ответ для вопроса типа число/ответ

                                if (array_key_exists('answer',$answerq)){
                                    //Если ответ был дан правильный
                                    if ($answerq['iscorrect']){
                                        $test['questions'][$key]['answers'][$k]['right'] = 2;
                                        $f = true;
                                        break;
                                    //Если ответ был дан неправильный, то помечаем его как неправильный
                                    //и показываем какой должен быть правильным
                                    } else {
                                        $test['questions'][$key]['answers'][$k]['right'] = 1;
                                        $test['questions'][$key]['answers'][] = $answerq;
                                        $test['questions'][$key]['answers'][count($test['questions'][$key]['answers'])-1]['right']=0;
                                        break;
                                    }
                                } else
                                //Если ответ с вариантами вопроса
                                //помечаем верность вопроса и необходимость добавления верных ответов отпадает
                                if ($answer['iscorrect']) {
                                    $test['questions'][$key]['answers'][$k]['right'] = 2;
                                    $f = true;
                                    break;
                                } else if (!$answer['iscorrect']) {
                                    $test['questions'][$key]['answers'][$k]['right'] = 1;
                                    $f = false;
                                    break;
                                }
                            }
                        }
                    }
                    //Если вариант ответа верный и флаг пометки требовалось поставить отрицательный,
                    //то делаем текущему вопросу пометку
                    if (!$f&&$answer['iscorrect']){
                        $test['questions'][$key]['answers'][$k]['right']=0;
                    }
                    if ($f) $countUserRightAnswers++;
                }
                $result['allWeight']+=$question['weight'];
                if ($countRightAnswers==$countUserRightAnswers){
                    $result['weight']+=$question['weight'];
                }
                //вес одного правильного ответа в вопросе
                $test['questions'][$key]['weightAnswer']=$question['weight']/$countRightAnswers;
            }
            $countQuestions=count($questions);
            $percent = round( $countRight / $countQuestions * 100 );
            $mark = round($result['weight']/$result['allWeight']*$test['maxmark']);
            $result ['percent'] = $percent;
            $result['mark'] = $mark;
            $res=['id_test' => $data['id_test'], 'id_user' => Auth::id(),
                'percent' => $percent, 'mark' => $mark,'passed'=>true];
            $resultModel->putResult($res,$idU,$idT);
            return view('passing.result',['test'=>$test,'questionsAnswers'=>$questionsAnswers,'result'=>$result]);
        }

        else if ($idAlg==2){
            $questionsAnswers=$data['data'];
            //собираем все вопросы и ответы
            $selectedQuestions=$utqModel->getQByUserTest(Auth::id(),$id);
            //Взятие рандомных вопросов согласно таблице userTestQuestions
            $allQuestions=[];
            foreach ($selectedQuestions as $key=>$item){
                $allQuestions[]=$questionModel->getQuestionById($item['id_question']);
            }


            $selectedAnswers=$utaModel->getAByUserTest(Auth::id(),$id);
            //Взятие рандомных ответов согласно таблице userTestAnswers
            $allAnswers=[];
            foreach ($selectedAnswers as $key=>$item){
                $allAnswers[]=$answerModel->getAnswerById($item['id_answer']);
            }


            $allWeight=0;
            //Удаляем варианты ответов, которых не было предоставлено студенту
            foreach ($allQuestions as $key=>$question){
                foreach($allQuestions[$key]['answers'] as $k=>$answer){
                    $f=true;
                    foreach ($allAnswers as $ka=>$allAnswer){
                        if ($answer['id']==$allAnswer['id']){
                            $f=false;
                            break;
                        }
                    }
                    if ($f){
                        array_splice($allQuestions[$key]['answers'],$k,1);
                    }
                }
                $allWeight+=$question['weight'];

                if (count($allQuestions[$key]['answers'])>1){
                    $allQuestions[$key]['weightAnswer']=$allQuestions[$key]['weight']/count($allQuestions[$key]['answers']);
                } else {
                    $allQuestions[$key]['weightAnswer']=$allQuestions[$key]['weight'];
                }
            }

//            if ($test['shuffle_questions']){
//                foreach ($questionsAnswers as $key => $row) {
//                    $ques[$key] = $row['question'];
//                    $answ[$key] = $row['answers'];
//                }
//                array_multisort($ques, SORT_ASC, $answ, SORT_ASC, $questionsAnswers);
//            }

            //Массив с результатами
            $result=[
                //кол-во вопрос, на которые дан хотя бы 1 правильный ответ
                'atLeast1'=>0,
                //кол-во неверных ответов
                'countFalse'=>0,
                //кол-во верных ответов
                'countRight'=>0,
                //кол-во верных ответов в выборке
                'allCountRight'=>0,
                'trueWeight'=>0,
                'atLeastWeight'=>0,
                'falseWeight'=>0
            ];
            //Подсчет кол-во верных ответов в выборке
            foreach ($allQuestions as $k=>$question){
                if (count($question['answers'])==0) {
                    $result['allCountRight']++;
                } else {
                    $result['allCountRight'] += count($question['answers']);
                }
            }

            //модификация выдаваемого массива и сбор правильных/неправильных ответов
            if (count($questionsAnswers)) {
                foreach ($questionsAnswers as $key => $value) {
                    $questionId = $value['question'];
                    $questionsAnswers[$key]['question'] = $allQuestions[$key];

                    //Ответы на текущий вопрос
                    $answers = $value['answers'];

                    //кол-во рандомно выбранных правильных ответов в текущем вопросе
                    $countRight = ResultController::checkCountRightAnswers($allAnswers, $questionId);

                    //переменная для кол-ва правильных ответов в текущем вопросе
                    $equivalentAnswers = 0;

                    //Кол-во данных пользователем ответов на вопрос
                    $count = count($answers);

                    //Если пользователь давал ответы на этот вопрос
                    if ($count > 0) {
                        foreach ($allAnswers as $k => $answer) {
                            $f = false;
                            for ($i = 0; $i < $count; $i++) {
                                //если текущий вариант не "Нет правильных ответов"
                                if ($questionsAnswers[$key]['answers'][$i]['id'] != 0) {
                                    //если ответ верный (по айди вопроса)
                                    if ($answers[$i]['id'] == $answer['id'] && $questionId == $answer['id_question']) {
                                        $equivalentAnswers++;
                                        $f = true;
                                        $questionsAnswers[$key]['answers'][$i]['right'] = 2;
                                        $result['countRight']++;
                                        $result['trueWeight'] += $allQuestions[$key]['weightAnswer'];
                                        continue;
                                    //если ответ неверный (по айди вопроса)
                                    } else if ($answers[$i]['id'] == $answer['id'] && $questionId != $answer['id_question']) {
                                        $questionsAnswers[$key]['answers'][$i]['right'] = 1;
                                        $result['countFalse']++;
                                        $result['falseWeight'] += $allQuestions[$key]['weightAnswer'];
                                        $f = true;
                                        continue;
                                    }
                                } //если текущий вариант "Нет правильных ответов"
                                else {
                                    //Если еще не было обозначено в проходе цикла то заходим
                                    if (!array_key_exists('right', $questionsAnswers[$key]['answers'][$i])) {
                                        //Если кол-во правильных ответов в выборке действительно 0 то защитываем как правильный
                                        if ($countRight == 0) {
                                            $equivalentAnswers++;
                                            $f = true;
                                            $questionsAnswers[$key]['answers'][$i]['right'] = 2;
                                            $result['trueWeight'] += $allQuestions[$key]['weightAnswer'];
                                        //Иначе как неправильный
                                        } else {
                                            $questionsAnswers[$key]['answers'][$i]['right'] = 1;
                                            $result['countFalse']++;
                                            $result['falseWeight'] += $allQuestions[$key]['weightAnswer'];
                                        }
                                        continue;
                                    }
                                }
                            }
                            //Если текущий проход цикла является правильным ответом, но не был добавлен пользователем,
                            //то помечаем его как "нужно было поставить но не поставили"
                            if ($questionId == $answer['id_question'] && !$f
                                && ResultController::getArrayIndex($answers, 'id', $answer['id']) === -1
                            ) {
                                $questionsAnswers[$key]['answers'][count($questionsAnswers[$key]['answers'])] = $answer;
                                $questionsAnswers[$key]['answers'][count($questionsAnswers[$key]['answers'])-1]['right'] = 0;
                            }
                            //0 - требуется поставить, 1 - поставлено неправильно, 2 - поставлено правильно
                        }
                    //Если пользователь не дал ответов на текущий вопрос
                    } else {
                        //Если правильных ответов на текущий вопрос действительно не было
                        if (count($allQuestions[$key]['answers'])==0){
                            $questionsAnswers[$key]['answers'][count($answers)] = ResultController::makeNullableAnswer();
                            $questionsAnswers[$key]['answers'][count($answers)]['right'] = 0;
                        }
                        //Если правильные ответы на текущий вопрос все таки были
                        else{
                            foreach ($allQuestions[$key]['answers'] as $keyR=>$answerR){
                                $questionsAnswers[$key]['answers'][count($questionsAnswers[$key]['answers'])] = $answerR;
                                $questionsAnswers[$key]['answers'][count($questionsAnswers[$key]['answers'])-1]['right'] = 0;
                            }
                        }

                    }
                    if ($equivalentAnswers > 0) {
                        $result['atLeast1']++;
                        $result['atLeastWeight'] += $allQuestions[$key]['weight'];
                    }
                    if (!$results['passed']) {
                        foreach ($answers as $k => $answer) {
                            if ($answer['id'] != 0) {
                                $qaItem = [
                                    'id_test' => $idT,
                                    'id_user' => $idU,
                                    'id_answer' => $answer['id'],
                                    'id_question' => $questionId,
                                    "created_at" => \Carbon\Carbon::now(),
                                    "updated_at" => \Carbon\Carbon::now()
                                ];
                                $testQA->insert($qaItem);
                            }
                        }
                    }


                }
            }
            $p=$test['maxmark']/2/$allWeight;
            $M1=$p*$result['atLeastWeight'];
            $Mtrue=$p*$result['trueWeight'];
            $Mfalse=$p/2*$result['falseWeight'];
            $result['markAtLeast']=$M1;
            $result['markTrue']=$Mtrue;
            $result['markFalse']=$Mfalse;
            $result['mark']=round($M1+$Mtrue-$Mfalse);
            //добавление результатов
            $res=['id_test' => $data['id_test'], 'id_user' => Auth::id(),
                'percent' => round($result['countRight']/$result['allCountRight']*100), 'mark' => $result['mark'],'passed'=>true];
            $resultModel->putResult($res,$idU,$idT);
            return view('passing.result',['test'=>$test,'questionsAnswers'=>$questionsAnswers,'result'=>$result,'res'=>$res]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    //Функция, ищущая $value=$arr[$index]
    public static function getArrayIndex($arr,$column,$key){
        foreach($arr as $k=>$v){
            if($v[$column]==$key){
                return $k;
            }
        }
        return -1;
    }
    //Функция для проверки в тесте Федорченко кол-ва правильных предоставленных ответов для вопроса.
    public static  function checkCountRightAnswers($answers,$id){
        $k=0;
        foreach ($answers as $key=>$value){
            if ($value['id_question']==$id){
                $k++;
            }
        }
        return $k;
    }
    public static function makeNullableAnswer(){
        return [
            'id'=>0,
            'answer'=> 'Нет правильных ответов',
            'id_question'=>0,
            'iscorrect'=>0
        ];
    }
}
