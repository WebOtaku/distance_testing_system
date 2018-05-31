<div class="navbar">

    <div class="navbar-brand">
        <a class="navbar-item" href="{{ route('home') }}">Система дистанционного тестирования</a>
    </div>

    <div class="navbar-menu">

        <div class="navbar-end">
            @if(Auth::check())

                <a class="navbar-item"  href="/workspace/profile/{{ auth()->user()->id }}">
                    {{ Auth::user()->surname }} {{ Auth::user()->name }}
                </a>

                <a class="navbar-item" href="/logout">Выйти</a>

            @else

                <a class="navbar-item" href="/register">Зарегистрироваться</a>
                <a class="navbar-item" href="/login">Войти</a>

            @endif
        </div>

    </div>

</div>