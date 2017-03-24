@extends('layouts.app')

@section('title') Выбор теста @stop
@section('content')


<div class="main">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-4 xs-comeout">
                
                <pass-sidebar></pass-sidebar>
                
            </div>
            <div class="col-lg-8 col-md-8 js-main-content">
                <div class="main-container">
                    <pass-select></pass-select>
                </div>
            </div>
        </div>
    </div>
</div>

@stop
@section('scripts') <script src="{{ URL::asset('js/pass.js') }}"></script> @stop