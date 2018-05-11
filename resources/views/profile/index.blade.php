@extends ('layouts.master')

@section ('content')

    <div class="profile">

        <h2>Профиль</h2>

        <div class="profile__full_name">
            <p class="profile__surname">Фамилия: {{ $user->surname }}</p>
            <p class="profile__name">Имя: {{ $user->name }}</p>
            <p class="profile__patronymic">Отчество: {{ $user->patronymic }}</p>
        </div>
        <div class="profile__status">
            <p>Статус: {{ $user->status->name }}</p>
        </div>

        @if ($user->status_id == 1)
            <div class="profile__speciality">
                <p>Специальность: {{ $user->student->speciality->name }}</p>
            </div>
            <div class="profile__group">
                <p>Группа: {{ $user->student->group }}</p>
            </div>
            <div class="profile__course">
                <p>Курс: {{ $user->student->course }}</p>
            </div>
        @endif

    </div>

@endsection
