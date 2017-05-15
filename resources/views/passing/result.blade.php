@extends('layouts.app')

@section('title') Результаты - {{$test['name']}} @stop

@section('content')
    <div class="main">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="container-lg">
                        <h2 class="text-center result__header">Результаты прохождения теста</h2>
                        @if ($test['id_alg']==1)
                            <div class="container-md">
                                {{--@if ($result['right']==$result['all'])--}}
                                    {{--<p>Вы ответили правильно на все вопросы!</p>--}}
                                {{--@elseif ($result['right']==0)--}}
                                    {{--<p>Вы не дали ни одного правильного ответа</p>--}}
                                {{--@else--}}
                                    {{--<p>Вы дали--}}
                                        {{--<b>{{$result['right']}}</b>--}}
                                        {{--@if ($result['right']%10==1)--}}
                                            {{--правильный ответ--}}
                                        {{--@elseif ($result['right']%10>1&&$result['right']%10<5)--}}
                                            {{--правильных ответа--}}
                                        {{--@elseif ($result['right']%10>=5||$result['right']%10==0)--}}
                                            {{--правильных ответов--}}
                                        {{--@endif--}}
                                        {{--из--}}
                                        {{--<b>{{count($test['questions'])}}</b></p>--}}
                                {{--@endif--}}
                                <p>
                                    Вы прошли тест на <b>{{$result['percent']}}%</b>
                                </p>
                                <p>
                                    Ваша оценка: <b>{{$result['mark']}}</b> <small>(Максимальная {{$test['maxmark']}})</small>
                                </p>
                                {{--<p>--}}
                                    {{--Процент правильных ответов: <b>{{$result['percent']}}%</b>--}}
                                {{--</p>--}}

                            </div>
                            {{--@foreach ($test['questions'] as $qK=>$question)--}}
                                {{--<div>--}}
                                    {{--<div>{{$question['question']}}</div>--}}
                                    {{--@foreach($question['answers'] as $aK=>$answer)--}}
                                        {{--@if($answer['right']!==null)--}}
                                            {{--<div>{{$answer['right']}} {{$answer['answer']}}</div>--}}
                                        {{--@endif--}}
                                    {{--@endforeach--}}
                                {{--</div>--}}
                            {{--@endforeach--}}
                            @if ($test['view_right_answers'])
                            <result-id1 tests="{{json_encode($test)}}">

                            </result-id1>
                            @endif

                        @elseif ($test['id_alg']==2)
                            <div class="container-md">
                                {{--<p>Правильных ответов: <span class="answer-label">{{$result['countRight']}}</span></p>--}}
                                {{--<p>Вопросы, на которые дан хотя бы 1 правильный ответ: <span class="answer-label">{{$result['atLeast1']}}</span></p>--}}
                                {{--<p>Неправильных ответов: <span class="answer-label">{{$result['countFalse']}}</span></p>--}}
                                {{--<br><br>--}}
                                {{--<p>--}}
                                    {{--Процент правильных ответов: <b>{{$res['percent']}}%</b>--}}
                                {{--</p>--}}
                                <h3>
                                    Вы прошли тест на <b>{{$res['percent']}}%</b>
                                </h3>
                                <h3>Ваша оценка: <b>{{$res['mark']}}</b> <small><b>(из {{$test['maxmark']}})</b></small></h3>

                            </div>
                            {{--@foreach ($questionsAnswers as $qK=>$question)--}}
                                {{--<div>--}}
                                    {{--<div>{{$question['question']['question']}}</div>--}}
                                    {{--@foreach($question['answers'] as $aK=>$answer)--}}
                                        {{--@if($answer['right']!==null)--}}
                                            {{-- 0 - требуется поставить, 1 - поставлено неправильно, 2 - поставлено правильно--}}
                                            {{--@if ($answer['right']=='0')--}}
                                                {{--<div>0 {{$answer['answer']}}</div>--}}
                                            {{--@elseif ($answer['right']=='1')--}}
                                                {{--<div>1 {{$answer['answer']}}</div>--}}
                                            {{--@elseif ($answer['right']=='2')--}}
                                                {{--<div>2 {{$answer['answer']}}</div>--}}
                                            {{--@endif--}}
                                        {{--@endif--}}
                                    {{--@endforeach--}}
                                {{--</div>--}}
                            {{--@endforeach--}}
                            @if ($test['view_right_answers'])
                            <result-id2 qa="{{json_encode($questionsAnswers)}}">

                            </result-id2>
                            @endif
                        @endif
                        <div class="extra__buttons">
                            <a href="/pass" class="btn btn-lg btn-primary">Вернуться к списку тестов на прохождение</a>
                        </div>
                    </div>
                </div>
                {{-- <pass-result
                    :test="{{$te}}"
                ></pass-result> --}}
            </div>
        </div>

    </div>
@stop
@section('scripts') <script src="{{ URL::asset('js/pass.js') }}"></script> @stop