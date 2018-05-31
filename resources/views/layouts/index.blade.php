@extends ('layouts.master')

{{--TODO:избавиться от индексовой страницы--}}

@section ('content')
    <p>Для использования системы небходимо войти или зарегистрироваться
        в случае если вы не имеет учётной записи.</p>
    <div class="link__group">
        <a href="/register">Зарегистрироваться</a>
        <a href="/login">Войти</a>
    </div>
@endsection

