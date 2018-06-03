@extends ('layouts.master')

@section ('content')

    <div class="authorization_form">

        <section class="section">

            <h1 class="title">Регистрация</h1>

            <h2 class="subtitle">Войти или <a href="/register">Зарегистрироваться</a></h2>

            <form method="POST" action="/login" class="form">

                {{ csrf_field() }}

                <div class="field">
                    <label class="label" for="email">E-mail</label>

                    <div class="control">
                        <input type="email" class="input" name="email" id="email"
                               aria-describedby="userEmail" required>
                    </div>
                </div>

                <div class="field">
                    <label class="label" for="password">Пароль</label>

                    <div class="control">
                        <input type="password" class="input" name="password" id="password"
                               aria-describedby="userPassword" required>
                    </div>
                </div>

                @include ('layouts.errors')

                <button type="submit" class="button is-primary">Войти</button>

            </form>

        </section>

    </div>

@endsection