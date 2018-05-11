{{--TODO:Доработать хедер--}}
<h1><a href="{{ route('home') }}">Система дистанционного тестирования</a></h1>
<div class="auth">
    @if(Auth::check())
        <div class="auth__user">
            <a href="/profile">{{ Auth::user()->surname }} {{ Auth::user()->name }}</a>
        </div>
        <div class="auth__controls">
            <a href="/logout">Выйти</a>
        </div>
    @else
        <div class="auth__controls">
            <a href="/register">Зарегистрироваться</a>
            <a href="/login">Войти</a>
        </div>
    @endif
</div>