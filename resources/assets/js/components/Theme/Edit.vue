<template>

    <div class="edit_theme">

        <section class="section">

            <h1 class="title">Редактирование темы</h1>

            <div class="notification is-primary" ref="notify" v-if="!hasErrors">
                <button class="delete" @click="closeNotify"></button>
                Тема была успешно обновлена
            </div>

            <form method="POST" class="form">

                <div class="field">
                    <label class="label" for="cicle">Цикл</label>

                    <div class="control">
                        <div class="select" ref="cicle">
                            <select name="cicle" id="cicle"
                                    @input="fetchDisciplines($event)"
                                    v-model="cicleId" required
                            >

                                <option v-for="cicle in cicles"
                                        :value="cicle.id"
                                >
                                    {{ cicle.name }}
                                </option>

                            </select>
                        </div>
                    </div>
                </div>

                <div class="field">
                    <label class="label" for="discipline_id">Дисциплина</label>

                    <div class="control">
                        <div class="select" ref="discipline_id">
                            <select name="discipline_id" id="discipline_id"
                                    v-model="theme.discipline_id" required
                            >

                                <option v-for="discipline in disciplines"
                                        :value="discipline.id"
                                >
                                    {{ discipline.name }}
                                </option>

                            </select>
                        </div>
                    </div>
                </div>

                <div class="field">
                    <label class="label" for="name">Название</label>
                    <div class="control">
                        <input type="text" class="input" name="name" id="name"
                               v-model="theme.name" required>
                    </div>
                </div>

                <div class="field">
                    <label class="label" for="course">Курс</label>
                    <div class="control">
                        <input type="number" class="input" name="course" id="course" aria-describedby="themeCourse"
                               v-model="theme.course" min="1" max="4" required>
                    </div>
                </div>

                <!--ERRORS-->
                <errors :errors="errors"></errors>

                <div class="field is-grouped">
                    <div class="control">
                        <button type="submit" class="button is-primary"
                                @click.prevent="updateTheme"
                        >
                            Cохранить
                        </button>
                    </div>

                    <div class="control">
                        <router-link class="button is-link is-outlined" to="/workspace/themes" exact>
                            Назад
                        </router-link>
                    </div>
                </div>

            </form>

        </section>

    </div>

</template>

<script>
    import Theme from '../../models/Theme';
    import Cicle from '../../models/Cicle';
    import Discipline from '../../models/Discipline';

    export default {
        data() {
            return {
                cicleId: 0,
                themeId: this.$route.params.themeId,
                theme: {
                    discipline_id: 0,
                    name: '',
                    course: 1
                },
                errors: {},
                cicles: [],
                disciplines: []
            }
        },

        computed: {
            hasErrors() {
                return Object.keys(this.errors).length !== 0;
            }
        },

        methods: {
            updateTheme($event) {
                $event.target.disabled = true;
                $event.target.classList.add('is-loading');

                Theme.update(this.theme, this.theme.id, data => {
                    if (!data.errors) {
                        $event.target.disabled = false;
                        $event.target.classList.remove('is-loading');
                        this.$refs.notify.classList.add('is-active');
                        setTimeout(() => {
                            this.$refs.notify.classList.remove('is-active');
                        }, 5000)
                    }
                    else {
                        this.errors = data.errors;
                        $event.target.disabled = false;
                        $event.target.classList.remove('is-loading');
                    }
                });
            },

            fetchDisciplines(cicleId, disciplineId) {
                this.$refs.discipline_id.classList.add('is-loading');

                // Проверка на то являеться ли cicleId событием
                cicleId = (typeof cicleId === 'object') ? cicleId.target.value : cicleId;

                Discipline.fetch(cicleId, disciplines => {
                    this.disciplines = disciplines;
                    this.theme.discipline_id = !!disciplineId ? disciplineId : disciplines[0].id;
                    this.$refs.discipline_id.classList.remove('is-loading');
                });
            },

            fetchCicles() {
                Cicle.fetchAll(cicles => {
                    this.cicles = cicles;
                    this.cicleId = cicles[0].id;
                    this.fetchDisciplines(cicles[0].id);
                });
            },

            fetchTheme() {
                Theme.fetch(this.themeId, theme => {
                    this.theme = theme;
                    this.cicleId = theme.discipline_teacher.discipline.cicle.id;
                    this.theme.discipline_id = theme.discipline_teacher.discipline.id;
                    this.fetchDisciplines(this.cicleId, this.theme.discipline_id);
                });
            },

            closeNotify() {
                this.$refs.notify.classList.remove('is-active');
            }
        },

        created() {
            this.fetchCicles();
            this.fetchTheme();
        }
    }
</script>

<style lang="scss" scoped>
    .notification {
        min-width: 200px;
        width: 300px;
        max-width: 400px;
        display: none;
    }
    .notification.is-active {
        display: block;
    }
</style>