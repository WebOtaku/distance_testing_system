@extends ('layouts.master')

@section ('content')

    <div class="authorization_form">

        <h2>Войти <span class="tip">или <a href="/register">Зарегистрироваться</a></span></h2>

        <form method="POST" action="/login" class="form">

            {{ csrf_field() }}

            <div class="form__group">
                <label for="email">E-mail</label>
                <input type="email" name="email" id="email" aria-describedby="userEmail" required>
            </div>

            <div class="form__group">
                <label for="password">Пароль</label>
                <input type="password" name="password" id="password" aria-describedby="userPassword" required>
            </div>

            @include ('layouts.errors')

            <button type="submit" class="btn btn-submit">Войти</button>

        </form>

    </div>

@endsection