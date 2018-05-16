<nav class="nav nav-main">

    <div class="nav__list">

        <ul>
            <router-link tag="li" to="/workspace/profile/{{ auth()->user()->id }}" exact>
                <a>Profile</a>
            </router-link>

            <router-link tag="li" to="/workspace/tests" exact>
                <a>Tests</a>
            </router-link>
        </ul>

    </div>

</nav>