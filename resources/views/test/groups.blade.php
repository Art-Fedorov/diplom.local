@extends('layouts.app')

@section('title') Редакитрование групп @stop
@section('content')

    <div class="main">

        {{--<results res="{{json_encode($results)}}"></results>--}}
        <groups gro="{{json_encode($groups)}}"></groups>
    </div>

@stop

@section('scripts') <script src="{{ URL::asset('js/app.js') }}"></script> @stop