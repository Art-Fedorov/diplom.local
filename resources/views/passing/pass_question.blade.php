@extends('layouts.app')

@section('title') Прохождение - {{$test['name']}} @stop

@section('content')
<div class="main">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div hidden>@{{showSidebar=false}}</div>
                <div class="main-container pass-question">
                    @if ($test['id_alg']==1)
                        <pass-id1
                                @if (isset($idResult))
                                    id-result="{{$idResult}}"
                                @endif
                                @if (isset($questionsAnswers))
                                qa="{{json_encode($questionsAnswers)}}"
                                @endif
                                @if (isset($timeInSeconds))
                                timer="{{json_encode($timeInSeconds)}}"
                                @endif
                                @if (isset($test))
                                test="{{json_encode($test)}}"
                                @endif
                                @if (isset($answers))
                                answ="{{json_encode($answers)}}"
                                @endif
                                @if (isset($questions))
                                ques="{{json_encode($questions)}}"
                                @endif
                                {{--@if (isset($answers))--}}

                            >
                        </pass-id1>
                    @elseif ($test['id_alg']==2)
                        <pass-id2
                            @if (isset($idResult))
                                id-result="{{$idResult}}"
                            @endif
                            {{--@if (isset($questionsAnswers))--}}
                                {{--qa="{{json_encode($questionsAnswers)}}"--}}
                            {{--@endif--}}
                            @if (isset($timeInSeconds))
                                timer="{{json_encode($timeInSeconds)}}"
                            @endif
                            @if (isset($test))
                                test="{{json_encode($test)}}"
                            @endif
                            @if (isset($answers))
                                answ="{{json_encode($answers)}}"
                            @endif
                            @if (isset($questions))
                                ques="{{json_encode($questions)}}"
                            @endif
                        >
                        </pass-id2>
                    @endif
                </div>
            </div>
        </div>    
    </div>
</div>

@stop
@section('scripts') <script src="{{ URL::asset('js/pass.js') }}"></script> @stop