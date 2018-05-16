<template>

    <div class="registration_form">

        <h2>Зарегистрироваться <span class="tip">или <a href="/login">Войти</a></span></h2>

        <form method="POST" action="/register" class="form" enctype="multipart/form-data">

            <!--CSRF-FIELD-->
            <slot name="csrf"></slot>

            <!--UserController Form-->
            <div class="form__group">
                <label for="surname">Фамилия</label>
                <input type="text" name="surname" id="surname" aria-describedby="userSurname" required>
            </div>

            <div class="form__group">
                <label for="name">Имя</label>
                <input type="text" name="name" id="name" aria-describedby="userName" required>
            </div>

            <div class="form__group">
                <label for="patronymic">Отчество</label>
                <input type="text" name="patronymic" id="patronymic" aria-describedby="userPatronymic" required>
            </div>

            <div class="form__group">
                <label for="email">E-mail</label>
                <input type="email" name="email" id="email" aria-describedby="userEmail" required>
            </div>

            <div class="form__group">
                <label for="password">Пароль</label>
                <input type="password" name="password" id="password" aria-describedby="userPassword" required>
            </div>

            <div class="form__group">
                <label for="password_confirmation">Подтверждение пароля</label>
                <input type="password" name="password_confirmation" id="password_confirmation"
                       aria-describedby="passwordСonfirmation" required>
            </div>

            <div class="form__group">
                <label for="status_id">Статус</label>
                <select name="status_id" id="status_id" aria-describedby="userStatus" v-model="userStatus" required>
                    <option value="1">Студент</option>
                    <option value="2">Преподаватель</option>
                </select>
            </div>

            <!--Student Form-->
            <template v-if="responseStatus && userStatus === '1'">

                <div class="form__group">
                    <label for="speciality_id">Специальность</label>
                    <select name="speciality_id" id="speciality_id" aria-describedby="studentSpeciality" required>
                        <option v-for="speciality in specialities"
                                :value="speciality.id"
                        >
                            {{ speciality.name + ' - ' + speciality.code }}
                        </option>
                    </select>
                </div>

                <div class="form__group">
                    <label for="group">Группа</label>
                    <input type="text" name="group" id="group" aria-describedby="studentGroup" required>
                </div>

                <div class="form__group">
                    <label for="course">Курс</label>
                    <input type="number" name="course" id="course" aria-describedby="studentCourse"
                           min="1" max="4" required>
                </div>

            </template>

            <div class="form__group">
                <label for="avatar">Аватар</label>
                <input type="hidden" name="MAX_FILE_SIZE" value="2097152">
                <input type="file" name="avatar" id="avatar" aria-describedby="userAvatar" required>
            </div>

            <!--ERRORS-->
            <slot name="errors"></slot>

            <button type="submit" class="btn btn-submit">Зарегистрироваться</button>

        </form>

    </div>

</template>

<script>
    export default {
        data() {
            return {
                userStatus: '2',
                specialities: [],
                responseStatus: false
            }
        },
        created() {
            axios.get('/specialities').then(response => {
                this.specialities = response.data;
                this.responseStatus = true;
            });
        }
    }
</script>
