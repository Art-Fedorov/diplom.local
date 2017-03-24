@extends('layouts.app')

@section('content')

@section('title') Cтарт - {{$test['name']}} @stop
<div class="main">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="main-container pass-question">

                    <div class="test-container-lg text-center">
                        <h2 class="text-center test-settings__header">{{$test['name']}}</h2>
                        <div class="test-settings text-left">
                            <div class="test-settings__subheader">
                                Дополнительная информация:
                            </div>
                            <div class="test-settings__item">
                                <b>{{$test['desc']}}</b>
                            </div>
                            <div class="test-settings__item">
                                Время на прохождение:
                                <b>{{$test['time']}}</b>
                            </div>
                            <div class="test-settings__item">
                                Максимальный балл за прохождение теста:
                                <b>{{$test['maxmark']}}</b>
                            </div>
                            @if ($test['id_alg']==1)
                            <div class="test-settings__item">
                                Если есть более одного правильного ответа, это
                                @if ($test['view_more_1_answer'])
                                    <b>показывается</b>
                                @else
                                    <b>скрывается</b>
                                @endif
                            </div>
                            @endif
                            <div class="test-settings__item">
                                Перемещение по вопросам:
                                @if ($test['pass_other_questions'])
                                    <b>произвольное</b>
                                @else
                                    <b>от вопроса к вопросу</b>
                                @endif
                            </div>
                        </div>
                        <a href="{{'/pass/test/'.$test['id'].'/pass'}}" class="btn btn-lg btn-success">Пройти тест</a>
                        @if ($test['id_alg']==2)
                        <div>
                            <div  class="text-danger text-left h4">Во время прохождения теста не нажимайте на кнопку "перезагрузка" в браузере! Это приведет к потере всех промежуточных результатов!</div>
                        </div>
                        @else
                        {{--<div>--}}
                            {{--<div class="text-danger text-left h4">Во время прохождения теста не нажимайте на кнопку назад в браузере! Это приведет к завершению прохождения теста!</div>--}}
                        {{--</div>--}}
                        @endif

                    </div>
                </div>
            </div>
        </div>    
    </div>
</div>
@stop

{{--@section('scripts') <script src="{{ URL::asset('js/pass.js') }}"></script> @stop--}}