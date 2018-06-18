<template>

    <div class="profile">

        <section class="section">

            <h1 class="title">Профиль</h1>

            <div class="content">

                <template v-if="hasUser">

                    <div class="profile-avatar">
                        <img :src="`/storage/${user.avatar}`" alt="аватар">
                    </div>

                    <ul class="profile-info">
                        <li>
                            <span class="has-text-primary">ФИО:</span>
                            {{ user.surname }} {{ user.name }} {{ user.patronymic }}
                        </li>

                        <li>
                            <span class="has-text-primary">Статус:</span>
                            {{ user.status.name }}
                        </li>

                        <template v-if="hasStudent">

                            <li>
                                <span class="has-text-primary">Специальность:</span>
                                {{ student.speciality.name }}
                            </li>

                            <li>
                                <span class="has-text-primary">Группа:</span>
                                {{ student.group }}
                            </li>

                            <li>
                                <span class="has-text-primary">Курс:</span>
                                {{ student.course }}
                            </li>

                        </template>

                        <template v-if="hasTeacher">

                            <li><span class="has-text-primary">Квалификация/Специальность:</span>
                                {{ teacher.speciality }}</li>

                        </template>
                    </ul>

                </template>

            </div>

        </section>

    </div>

</template>

<script>
    import User from '../models/User';
    import Student from '../models/Student';
    import Teacher from '../models/Teacher';

    export default {
        data() {
            return {
                userId: this.$route.params.userId,
                user: {},
                student: {},
                teacher: {}
            }
        },

        computed: {
            hasUser() {
                return Object.keys(this.user).length !== 0;
            },

            hasStudent() {
                return Object.keys(this.student).length !== 0;
            },

            hasTeacher() {
                return Object.keys(this.teacher).length !== 0;
            }
        },

        methods: {
            fetchUser() {
                User.fetch(this.userId, user => {
                    this.user = user;

                    if (user.status.id === 1) {
                        this.fetchTeacher();
                    }
                    else if (user.status.id === 2) {
                        this.fetchStudent();
                    }
                });
            },

            fetchStudent() {
                Student.fetch(this.user.id, student => {
                    this.student = student;
                });
            },

            fetchTeacher() {
                Teacher.fetch(this.user.id, teacher => {
                    this.teacher = teacher;
                });
            }
        },

        created() {
            this.fetchUser();
        }
    }
</script>

<style lang="scss" scoped>
    .content {
        display: flex;
        flex-wrap: wrap;
    }

    .profile .profile-avatar {
        min-width: 100px;
        max-width: 160px;
    }

    .profile .profile-avatar img {
        border: 2px solid #00D1B2;
        border-radius: 8px;
    }

    .profile .profile-info {
        flex: 0 1 416px;
        margin-left: 1em;
        list-style: none;
        font-size: 1.15em;
    }

    @media screen and (max-width: 660px) {
        .content {
            justify-content: center;
        }

        .profile .profile-info {
            text-align: center;
        }
    }
</style>