<template>

    <div class="create_theme">

        <section class="section">

            <h1 class="title">
                Добавление темы
            </h1>

            <form method="POST" class="form">

                <div class="field">
                    <label class="label" for="cicle">Цикл</label>
                    <div class="control">
                        <div class="select" ref="cicle">
                            <select name="cicle" id="cicle" @input="fetchDisciplines({}, $event)"
                                    aria-describedby="disciplineCicle" v-model="cicleId" required
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
                                    aria-describedby="themeDiscipline" v-model="theme.discipline_id" required
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
                        <input type="text" class="input" name="name" id="name" aria-describedby="themeName"
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

                <button type="submit" class="button is-primary" @click.prevent="createTheme">
                    Cохранить
                </button>

                <router-link class="button is-link" ref="link_back" to="/workspace/tests" exact>
                    Назад
                </router-link>

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

        methods: {
            createTheme($event) {
                $event.target.disabled = true;
                $event.target.classList.add('is-loading');

                Theme.store(this.theme, data => {
                    if (!data.errors) {
                        document.location.href = `/workspace/themes`;
                    }
                    else {
                        this.errors = data.errors;
                        $event.target.disabled = false;
                        $event.target.classList.remove('is-loading');
                    }
                });
            },

            fetchDisciplines(cicleId, $event) {
                this.$refs.discipline_id.classList.add('is-loading');

                if (typeof cicleId === 'object') {
                    cicleId = $event.target.value;
                }

                Discipline.fetch(cicleId, disciplines => {
                    this.disciplines = disciplines;
                    this.theme.discipline_id = disciplines[0].id;
                    this.$refs.discipline_id.classList.remove('is-loading');
                });
            },

            fetchCicles() {
                Cicle.fetchAll(cicles => {
                    this.cicles = cicles;
                    this.cicleId = cicles[0].id;
                    this.fetchDisciplines(cicles[0].id);
                })
            }
        },

        created() {
            this.fetchCicles();
        }
    }
</script>
