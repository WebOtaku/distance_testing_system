<div class="navbar-start">

    <router-link class="navbar-item" to="/workspace/profile/{{ auth()->user()->id }}" exact>
        <a>Профиль</a>
    </router-link>

    <div class="navbar-item has-dropdown is-hoverable">

        <router-link class="navbar-link" to="/workspace/tests" exact>
            Тесты
        </router-link>

        <div class="navbar-dropdown is-rounded">

            <router-link class="navbar-item is-inline-block" to="/workspace/tests/create" exact>
                Добавить тест
            </router-link>

        </div>

    </div>

    <div class="navbar-item has-dropdown is-hoverable">

        <router-link class="navbar-link" to="/workspace/themes" exact>
            Темы
        </router-link>

        <div class="navbar-dropdown is-rounded">

            <router-link class="navbar-item is-inline-block" to="/workspace/themes/create" exact>
                Добавить тему
            </router-link>

        </div>

    </div>

</div>
