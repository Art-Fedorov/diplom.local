@extends('layouts.app')

@section('title') Тестирование студентов в ПГУ @stop

@section('content')
<div class="welcome">

    <div class="welcome__header">
        @if (isset($user))
            Здравствуйте, {{$user['name']}}.<br>
        @endif
        Добро пожаловать на главную страницу приложения тестирования студентов</div>

    <div class="welcome__support">
        @if (isset($role))
            @if ($role=='teacher')
                <a href="/test" class="welcome__btn welcome__btn--solo">Перейти к созданию тестов</a>
            @elseif ($role=='user')
                <a href="/pass" class="welcome__btn welcome__btn--solo">Просмотр тестов на прохождение</a>
            @endif
        @else
            <a class="welcome__btn" href="/register">Зарегистрируйтесь</a> или <a class="welcome__btn" href="/login">войдите</a> в свою учетную запись!
        @endif
    </div>
</div>



@stop