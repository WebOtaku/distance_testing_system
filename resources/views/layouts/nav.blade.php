<nav class="navbar">

    {{--TODO: Объдинить навигация в навбаре и в хедере--}}

    <div class="navbar-menu">

        <ul class="navbar-start">
            <router-link tag="li" to="/workspace/profile/{{ auth()->user()->id }}" exact>
                <a class="navbar-item">Профиль</a>
            </router-link>

            <router-link tag="li" to="/workspace/tests" exact>
                <a class="navbar-item">Тесты</a>
            </router-link>
        </ul>

    </div>

</nav>