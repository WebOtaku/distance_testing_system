<template>

    <div class="registration_form">

        <section class="section">

            <h1 class="title">Регистрация</h1>

            <h2 class="subtitle">Зарегистрироваться или <a href="/login">Войти</a></h2>

            <form method="POST" action="/register" class="form" enctype="multipart/form-data">

                <!--CSRF-FIELD-->
                <slot name="csrf"></slot>

                <!--UserController Form-->
                <div class="field">
                    <label class="label" for="status_id">Статус</label>

                    <div class="select">
                        <select name="status_id" id="status_id"
                                aria-describedby="userStatus" v-model="userStatus" required>
                            <option :value="1">Преподаватель</option>
                            <option :value="2">Студент</option>
                        </select>
                    </div>
                </div>

                <div class="field">
                    <label class="label" for="surname">Фамилия</label>

                    <div class="control">
                        <input type="text" name="surname" class="input" id="surname"
                               aria-describedby="userSurname" required>
                    </div>
                </div>

                <div class="field">
                    <label class="label" for="name">Имя</label>

                    <div class="control">
                        <input type="text" name="name" class="input" id="name"
                               aria-describedby="userName" required>
                    </div>
                </div>

                <div class="field">
                    <label class="label" for="patronymic">Отчество</label>

                    <div class="control">
                        <input type="text" name="patronymic" class="input" id="patronymic"
                               aria-describedby="userPatronymic" required>
                    </div>
                </div>

                <div class="field">
                    <label class="label" for="email">E-mail</label>

                    <div class="control">
                        <input type="email" name="email" class="input" id="email"
                               aria-describedby="userEmail" required>
                    </div>
                </div>

                <div class="field">
                    <label class="label" for="password">Пароль</label>

                    <div class="control">
                        <input type="password" name="password" class="input" id="password"
                               aria-describedby="userPassword" required>
                    </div>
                </div>

                <div class="field">
                    <label class="label" for="password_confirmation">Подтверждение пароля</label>

                    <div class="control">
                        <input type="password" name="password_confirmation" class="input"
                               id="password_confirmation" aria-describedby="passwordСonfirmation" required>
                    </div>
                </div>

                <!--Teacher Form-->
                <template v-if="userStatus === 1">

                    <div class="field">
                        <label class="label" for="speciality">Квалификация/специальность</label>

                        <div class="control">
                            <textarea name="speciality" class="textarea" id="speciality" rows="4"
                                      aria-describedby="teacherSpeciality" required></textarea>
                        </div>
                    </div>

                </template>


                <!--Student Form-->
                <template v-if="specialities.length && userStatus === 2">

                    <div class="field">
                        <label class="label" for="speciality_id">Специальность</label>

                        <div class="select">
                            <select name="speciality_id" id="speciality_id"
                                    aria-describedby="studentSpeciality" required>
                                <option v-for="speciality in specialities"
                                        :value="speciality.id"
                                >
                                    {{ speciality.code + ' - ' + speciality.name }}
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="field">
                        <label class="label" for="group">Группа</label>

                        <div class="control">
                            <input type="text" name="group" class="input" id="group"
                                   aria-describedby="studentGroup" required>
                        </div>
                    </div>

                    <div class="field">
                        <label class="label" for="course">Курс</label>

                        <div class="control">
                            <input type="number" name="course" class="input" id="course"
                                   aria-describedby="studentCourse" min="1" max="4" value="1" required>
                        </div>
                    </div>

                </template>


                <div class="field">
                    <label class="label" for="avatar">Аватар</label>

                    <div class="file">
                        <label class="file-label">
                            <input type="hidden" name="MAX_FILE_SIZE" value="2097152">
                            <input type="file" class="file-input" name="avatar" id="avatar"
                                   aria-describedby="userAvatar" required>
                            <span class="file-cta">
                                <span class="file-icon">
                                    <i class="fas fa-upload"></i>
                                </span>

                                <span class="file-label">
                                    Выберите файл...
                                </span>
                            </span>
                        </label>
                    </div>
                </div>

                <!--ERRORS-->
                <slot name="errors"></slot>

                <button type="submit" class="button is-primary">Зарегистрироваться</button>

            </form>

        </section>

    </div>

</template>

<script>
    import Speciality from '../models/Speciality';

    export default {
        data() {
            return {
                userStatus: 1,
                specialities: []
            }
        },

        created() {
            Speciality.fetchAll(specialities => {
                this.specialities = specialities;
            });
        }
    }
</script>
