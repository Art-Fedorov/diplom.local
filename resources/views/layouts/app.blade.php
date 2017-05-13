<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>


    <!-- Styles -->
{{--     <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css"> --}}
    <link rel="stylesheet" href="/css/app.css">

    {{-- <script src="{{ URL::asset('js/tinymce/tinymce.min.js') }}"></script> --}}
    <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>
</head>
<body>
    <?php 
    use App\Models\User; 
    $user = new User();
    $userData=$user->getUserById(Auth::id());
    $userRole=$userData['role'];
    ?>
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <button v-if="showSidebar" class="sidebar-button btn btn-primary">Показать сайдбар</button>
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{--{{ config('app.name', 'Laravel') }}--}}
                        Опрос студентов
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    {{-- <ul class="nav navbar-nav">
                        &nbsp;
                    </ul> --}}

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                            

                        <!-- Authentication Links -->
                        @if (Auth::guest())
                            <li><a href="{{ url('/login') }}">Войти</a></li>
                            <li><a href="{{ url('/register') }}">Регистрация</a></li>
                        @else
                            @if ($userRole=='admin')
                                <li><a href="/groups">Группы</a></li>
                                <li><a href="/users">Пользователи</a></li>
                            @endif
                            @if ($userRole=='teacher')
                                <li><a href="/test">Создать тест</a></li>
                                <li><a href="/results">Результаты</a></li>
                            @endif
                            @if ($userRole=='user')
                             <li><a href="/pass">Пройти тест</a></li>
                            @endif
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="{{ url('/logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Выйти
                                        </a>

                                        <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>
        
        {{--@if(count($errors)>0)--}}
            {{--<div class="alert alert-danger">--}}
                {{--<ul>--}}
                    {{--@foreach ($errors->all() as $error)--}}
                    {{--<li>{{ $error }}</li>--}}
                    {{--@endforeach--}}
                {{--</ul>--}}
            {{--</div>--}}
        {{--@endif--}}
        
        @yield('content')


        <footer>
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h4 class="text-center">Выпускная квалификационная работа. Сделано Федоровым Артемом.</h4>
                    </div>
                </div>
            </div>
        </footer>
    </div>





    <script src="{{ URL::asset('js/welcome.js') }}"></script>
    <!-- Scripts -->
    @yield('scripts')


</body>
</html>
