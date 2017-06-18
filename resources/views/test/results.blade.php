<?php
/**
 * Created by PhpStorm.
 * User: pomos
 * Date: 12.03.2017
 * Time: 15:44
 */
?>
@extends('layouts.app')

@section('title') Просмотр результатов @stop
@section('content')

    <div class="main">
        
        <results res="{{json_encode($results)}}"></results>

    </div>

@stop

@section('scripts') <script src="{{ URL::asset('js/app.js') }}"></script> @stop