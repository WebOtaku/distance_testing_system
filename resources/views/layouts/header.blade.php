<nav class="navbar is-primary is-fixed-top">

    <div class="container is-fluid">

        <div class="navbar-brand">
            <a class="navbar-item" href="{{ route('home') }}">Система дистанционного тестирования</a>

            <a role="button" id="navbar-burger-id" class="navbar-burger" aria-label="menu"
               @click="openNavBurger($event)" aria-expanded="false"
            >
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
            </a>
        </div>

        <div class="navbar-menu" id="navbar-menu-id" ref="main_menu">

            @if(Auth::check())

                @include ('layouts.nav')

            @endif

            <div class="navbar-end">

                @if(Auth::check())

                    <router-link class="navbar-item" to="/workspace/profile/{{ auth()->user()->id }}">
                        {{ Auth::user()->surname }} {{ Auth::user()->name }}
                    </router-link>

                    <a class="navbar-item" href="/logout">Выйти</a>

                @else

                    <a class="navbar-item" href="/register">Зарегистрироваться</a>

                    <a class="navbar-item" href="/login">Войти</a>

                @endif

            </div>

        </div>

    </div>

</nav>
