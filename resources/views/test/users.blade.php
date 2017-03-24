@extends('layouts.app')

@section('title') Редакитрование пользователей @stop
@section('content')

    <div class="main">

        {{--<results res="{{json_encode($results)}}"></results>--}}
        <users uss="{{json_encode($users)}}"></users>
    </div>

@stop

@section('scripts') <script src="{{ URL::asset('js/app.js') }}"></script> @stop