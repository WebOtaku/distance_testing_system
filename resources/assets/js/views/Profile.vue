<template>

    <div class="profile">

        <section class="section">

            <h1 class="title">
                Профиль
            </h1>

            <template v-if="userStatus">

                <div class="profile__avatar">
                    <img width="180" :src="`/storage${user.avatar}`" alt="аватар">
                </div>

                <div class="profile__full_name">
                    <p class="profile__surname">Фамилия: {{ user.surname }}</p>
                    <p class="profile__name">Имя: {{ user.name }}</p>
                    <p class="profile__patronymic">Отчество: {{ user.patronymic }}</p>
                </div>

                <div class="profile__status">
                    <p>Статус: {{ user.status.name }}</p>
                </div>

            </template>

            <template v-if="studentStatus && user.status.id === 2">

                <div class="profile__speciality">
                    <p>Специальность: {{ student.speciality.name }}</p>
                </div>

                <div class="profile__group">
                    <p>Группа: {{ student.group }}</p>
                </div>

                <div class="profile__course">
                    <p>Курс: {{ student.course }}</p>
                </div>

            </template>

        </section>

    </div>

</template>

<script>
    import User from '../models/User';
    import Student from '../models/Student';

    export default {
        data() {
            return {
                user: {},
                userStatus: false,
                student: {},
                studentStatus: false
            }
        },

        created() {
            User.fetch(user => {
                this.user = user;
                this.userStatus = true;
            });

            Student.fetch(student => {
                this.student = student;
                this.studentStatus = true;
            });
        }
    }
</script>