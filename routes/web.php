<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/
use App\Models\Answer;
use App\Models\Group;
use App\Models\Test;
use App\Models\Question;
use App\Models\Result;
use App\Models\User;
use App\Models\UserTestQA;
use App\Models\UserTestQuestions;
use App\Models\UserTestAnswers;
use Illuminate\Http\Request;
use Carbon\Carbon;

Route::get('/', function () {
    if (Auth::check()) {
        $user = new User();
        $userInfo=$user->getUserById(Auth::id());
        $role = $userInfo['role'];
        return view('welcome',['role'=>$role,'user'=>$userInfo]);
    }
    return view('welcome');

});

Auth::routes();
Route::get('/home', 'HomeController@index');

//$router->resource('test','TestController');
//$router->resource('question','QuestionController');
//$router->resource('answer','AnswerController');
Route::group(['prefix' => 'api'], function() {
    //Route::resource('/group', 'GroupController');
});

Route::group(['middleware' => 'auth'], function () {

    Route::get('/api/user/', ['uses' => 'UserController@index', 'as' => 'user.index']);
    Route::get('/api/user/all', ['uses' => 'UserController@all', 'as' => 'user.all']);
    Route::put('/api/user/update/{id}', ['uses' => 'UserController@update', 'as' => 'user.update']);

    Route::get('/test',function(){
        if (redr('user')) return redirect('/');
        return view('test.main');
    });


    Route::get('/pass',function(){
        if (redr('teacher')) return redirect('/');
        return view('passing.main');
    });


    Route::get('/results',function(){
        if (redr('user')) return redirect('/');
        $resultModel=new Result();
        $results=$resultModel->getAllResults();
        foreach ($results as $k=>$item){
            if ($item['test']['id_user']!=Auth::id()){
                array_splice($results,$k,1);
            }
        }
        //dump($results);
        return view('test.results',['results'=>$results]);
    });

//    Route::get('/results',function(){
//        if (redr('user')) return redirect('/');
//        $resultModel=new Result();
//        $results=$resultModel->getAllResults();
//        foreach ($results as $k=>$item){
//            if ($item['test']['id_user']!=Auth::id()){
//                array_splice($results,$k,1);
//            }
//        }
//        //dump($results);
//        return view('test.results',['results'=>$results]);
//    });

    Route::get('/groups',function(){
        if (!redr('admin')) return redirect('/');
        $resultModel=new Result();
        $groups=(new Group())->getGroups();
        return view('test.groups',['groups'=>$groups]);
    });
    Route::get('/users',function(){
        if (!redr('admin')) return redirect('/');
        $users=(new User())->getUsers();
        return view('test.users',['users'=>$users]);
    });


    Route::get('/pass/test/{id}/start',function($id,Request $request,Result $resultModel){
        if (redr('teacher')) return redirect('/');


        $data=$resultModel->getResultsByUserTest(Auth::id(),$id);

        if (!count($data)) {
        } else {

            //$idResult=$data['id'];
            if($data['passed']){
                return redirect('pass');
            }
        }
        $tm=new Test();
        $data=$tm->getTestById($id);
        if($request->session()->has('date_start_passing'.$id)){
            return redirect('pass/test/'.$id.'/pass');
        }
//        if (!count($data)) {
//            $result = [
//                'id_test' => $id,
//                'id_user' => Auth::id()
//            ];
//            $idResult=$resultModel->insertGetId($result);
//        } else {
//
//            $idResult=$data['id'];
//            if($data['passed']){
//                return redirect('pass');
//            }
//        }
        return view('passing.pass_test',['test'=>$data]);
    });


    Route::get('/pass/test/{id}/delete', function($id, Request $request,UserTestQA $testQA,
        Result $resultModel,Question $questionModel, Answer $answerModel, UserTestAnswers $utaModel, UserTestQuestions $utqModel){
        $resultModel->deleteResult(Auth::id(),$id);
        $testQA->deleteItem(Auth::id(),$id);
        $utqModel->deleteQuestions(Auth::id(),$id);
        $utaModel->deleteAnswers(Auth::id(),$id);
    });


    Route::get('/pass/test/{id}/pass',['as'=>'pass.pass',function($id, Request $request,UserTestQA $testQA,
            Result $resultModel,Question $questionModel, Answer $answerModel, UserTestAnswers $utaModel, UserTestQuestions $utqModel){
        if (redr('teacher')) return redirect('/');
        //Забывание сессии (для тестирования программы)
        //$request->session()->forget('date_start_passing'.$id);


        //Получение теста
        $tm=new Test();
        $test=$tm->getTestById($id);


        //Попытка получения результатов с данным индексом
        $data=$resultModel->getResultsByUserTest(Auth::id(),$id);


        //если результата нет, то добавляем его с нулевыми значениями (потом будем изменять)
        if (!count($data)) {
            $result = [
                'id_test' => $id,
                'id_user' => Auth::id()
            ];
            $idResult=$resultModel->insertGetId($result);
        //иначе делаем редирект
        } else {

            $idResult=$data['id'];
            if($data['passed']){
                return redirect('pass');
            }
        }


        //если тест уже пройден, делаем редирект
        //if ($data[0]['passed']) return redirect('pass');


        //Получение времени, прошедшего с начала прохождения теста
        $timeInSeconds=0;
        if(!$request->session()->has('date_start_passing'.$id)) {
            $request->session()->put('date_start_passing'.$id, Carbon::now());
        } else {
            $timeInSeconds= Carbon::now()->diffInSeconds(Carbon::parse($request->session()->get('date_start_passing'.$id)));
        }


        if ($test['id_alg']==2) {
            //проверить, были ли добавлены уже вопросы и ответы (перезагружена ли страница)
            $selectedQuestions=$utqModel->getQByUserTest(Auth::id(),$id);
            if(count($selectedQuestions)==0){
                //получение всех вопросов и ответов теста
                $questions = $questionModel->getQuestionsByIdTest($id);

                //получение количества удаляемых элементов из массива;
                $countQuestions = count($test['questions']) - $test['count_questions'];

                //получение рандомных индексов удаляемых из массивов вопросов и ответов элементов
                if ($countQuestions>0) {
                    $randQ = array_rand($questions, $countQuestions);

                    //если кол-во удаляемых эл-ов 1 , то переменная становится числом а не массивом
                    if (gettype($randQ)!='array') $randQ=[0=>$randQ];

                    //Процесс удаления элементов
                    foreach ($randQ as $key => $item) {
                        array_splice($questions, $item-$key, 1);
                    }
                }

                //Перемешивание полученого массива с вопросами
                shuffle($questions);

                //процесс помещения выбранных вопросов и ответов в таблицы user_test_questions and _answers
                foreach ($questions as $k=>$item){
                    $data = [
                        'id_test' => intval($id),
                        'id_user' => Auth::id(),
                        'id_question' => $item['id'],
                        "created_at" => Carbon::now(),
                        "updated_at" => Carbon::now()
                    ];
                    $utqModel->insert($data);
                }
                $selectedQuestions=$utqModel->getQByUserTest(Auth::id(),$id);
            }
            //Взятие рандомных вопросов согласно таблице userTestQuestions
            $questions=[];
            foreach ($selectedQuestions as $key=>$item){
                $questions[]=$questionModel->getQuestionById($item['id_question']);
            }


            $selectedAnswers=$utaModel->getAByUserTest(Auth::id(),$id);
            if(count($selectedAnswers)==0) {
                //получение всех вопросов и ответов теста
                $answers = $answerModel->getAnswerByIdTest($id);

                //получение количества удаляемых элементов из массива;
                $countAnswers = count($test['answers']) - $test['count_answers'];

                //если кол-во удаляемых элементов больше 0
                if ($countAnswers>0) {
                    //получение рандомных индексов удаляемых из массивов вопросов и ответов элементов
                    $randA = array_rand($answers, $countAnswers);

                    //если кол-во удаляемых эл-ов 1 , то переменная становится числом а не массивом
                    if (gettype($randA)!='array') $randA=[0=>$randA];
                    //Процесс удаления элементов
                    foreach ($randA as $key => $item) {
                        array_splice($answers, $item-$key, 1);
                    }
                }

                //Перемешивание полученого массива с ответами
                shuffle($answers);

                //процесс помещения выбранных вопросов и ответов в таблицы user_test_questions and _answers
                foreach ($answers as $k => $item) {
                    if ($item['id']!=0) {
                        $data = [
                            'id_test' => intval($id),
                            'id_user' => Auth::id(),
                            'id_answer' => $item['id'],
                            "created_at" => Carbon::now(),
                            "updated_at" => Carbon::now()
                        ];
                        $utaModel->insert($data);
                    }
                }
                $selectedAnswers=$utaModel->getAByUserTest(Auth::id(),$id);
            }
            //Взятие рандомных ответов согласно таблице userTestAnswers
            $answers=[];
            foreach ($selectedAnswers as $key=>$item){
                $answers[]=$answerModel->getAnswerById($item['id_answer']);
            }
            $answers[]=\App\Http\Controllers\ResultController::makeNullableAnswer();

            return view('passing.pass_question',['idResult'=>$idResult,'test'=>$test,
                'timeInSeconds'=>$timeInSeconds,'answers'=>$answers,'questions'=>$questions]);
        }


        else if ($test['id_alg']==1){

            $questionsAnswers=$testQA->getQAByUserTest(Auth::id(),$id);
            //$questionsAnswers=$request->session()->get('questionsAnswers'.$id);

            //Возвращаем вьюшку с данными
            return view('passing.pass_question',['idResult'=>$idResult,'test'=>$test,
                'timeInSeconds'=>$timeInSeconds,'questionsAnswers'=>$questionsAnswers]);
        }


    }]);




    Route::post('/pass/test/{id}/result',['uses' => 'ResultController@update', 'as' => 'pass.update']);
    Route::group(['prefix' => 'api'], function() {
        Route::resource('/question', 'QuestionController');
        Route::resource('/answer', 'AnswerController');
        Route::resource('/algorithm', 'AlgorithmController');
        //Route::get('/answer/answers',['uses' => 'AnswerController@answers', 'as' => 'answer.answers']);
        Route::resource('/testgroups', 'TestGroupsController');
        Route::resource('/test', 'TestController');
        Route::resource('/usertestqa', 'UserTestQAController');
        Route::resource('/result', 'ResultController');
        Route::get('/group/', ['uses' => 'GroupController@index', 'as' => 'group.index']);
        Route::get('/group/all', ['uses' => 'GroupController@all', 'as' => 'group.all']);
        Route::post('/group/store', ['uses' => 'GroupController@store', 'as' => 'group.store']);
        Route::put('/group/update/{id}', ['uses' => 'GroupController@update', 'as' => 'group.update']);
        Route::get('/test/{test}', ['uses' => 'TestController@show', 'as' => 'test.show'])->where(['id' => '[0-9]+']);
    });
//Route::get('api/question/{test}/create',['as'=>'question.create','uses'=>'QuestionController@create']);
Route::get('api/answer/{question}/create',['as'=>'answer.create','uses'=>'AnswerController@create']);
});

function redr($need){
    $user=new User();
    $role=$user->getUserById(Auth::id())['role'];
    if ($role==$need){
        return true;
    }
    return false;
}
