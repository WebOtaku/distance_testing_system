<template>

    <div class="create_test">

        <section class="section">

            <h2 class="title">Создание теста</h2>

            <form method="POST" class="form">

                <h2 class="subtitle">Основная информация:</h2>

                <div class="field">
                    <label class="label" for="speciality_id">Специальность</label>

                    <div class="select">
                        <select name="speciality_id" id="speciality_id" aria-describedby="testSpeciality"
                                v-model="test.speciality_id" required
                        >
                            <option v-for="speciality in specialities"
                                    :value="speciality.id"
                            >
                                {{ speciality.name }}
                            </option>
                        </select>
                    </div>
                </div>

                <div class="field">
                    <label class="label" for="theme_id">Тема</label>

                    <div class="select">
                        <select name="theme_id" id="theme_id" aria-describedby="testTheme"
                                v-model="test.theme_id" required
                        >
                            <option v-for="theme in themes"
                                    :value="theme.id"
                            >
                                {{ theme.name }}
                            </option>
                        </select>
                    </div>
                </div>

                <div class="field">
                    <label class="label" for="name">Название</label>

                    <div class="control">
                        <input type="text" class="input" name="name" id="name" aria-describedby="testName"
                               v-model="test.name" required>
                    </div>
                </div>

                <div class="field">
                    <label class="label" for="number_questions">Количество вопросов</label>

                    <div class="control">
                        <input type="number" class="input" name="number_questions" id="number_questions"
                               aria-describedby="testName" min="1" max="99"
                               v-model="test.number_questions" required>
                    </div>
                </div>

                <h2 class="subtitle">Разбаловка:</h2>

                <div class="field is-grouped score-scales">

                    <div class="field"
                         v-for="(score_scale, index) in test.score_scales"
                    >

                        <label class="label" :for="`score-scale-${index}`">
                            {{ score_scale.score }} :
                        </label>

                        <div class="control">
                            от <input type="number" class="input" :id="`score-scale-${index}`"
                                      min="1" max="99" aria-describedby="scaleFrom"
                                      v-model="score_scale.from">
                        </div>

                        <div class="control">
                            до <input type="number" class="input"
                                      min="1" max="99" aria-describedby="scaleTo"
                                      v-model="score_scale.to">
                        </div>

                    </div>

                </div>

                <!--ERRORS-->
                <errors :errors="errors"></errors>

                <div class="field is-grouped">
                    <div class="control">
                        <button type="submit" class="button is-primary" @click.prevent="createTest">
                            Создать
                        </button>
                    </div>

                    <div class="control">
                        <router-link class="button is-link is-outlined" to="/workspace/tests" exact>
                            Назад
                        </router-link>
                    </div>
                </div>

            </form>

        </section>

    </div>

</template>

<script>
    import Test from '../../models/Test';
    import Theme from '../../models/Theme';
    import Speciality from '../../models/Speciality';

    export default {
        data() {
            return {
                test: {
                    speciality_id: 0,
                    theme_id: 0,
                    name: '',
                    number_questions: 1,
                    score_scales: [
                        {
                            score: 2,
                            from: 1,
                            to: 1
                        },
                        {
                            score: 3,
                            from: 1,
                            to: 1
                        },
                        {
                            score: 4,
                            from: 1,
                            to: 1
                        },
                        {
                            score: 5,
                            from: 1,
                            to: 1
                        }
                    ]
                },
                testId: 0,
                errors: {},
                themes: [],
                specialities: []
            }
        },

        methods: {
            createTest($event) {
                $event.target.disabled = true;

                Test.store(this.test, data => {
                    if (!data.errors) {
                        this.testId = data.test_id;
                        document.location.href = `/workspace/tests/edit/${this.testId}`;
                    }
                    else {
                        this.errors = data.errors;
                        $event.target.disabled = false;
                    }
                });
            },

            fetchThemes() {
                Theme.fetchAll(themes => {
                    this.themes = themes;
                    this.test.theme_id = themes[0].id;
                });
            },

            fetchSpecialities() {
                Speciality.fetchAll(specialities => {
                    this.specialities = specialities;
                    this.test.speciality_id = specialities[0].id;
                });
            }
        },

        created() {
            this.fetchThemes();
            this.fetchSpecialities();
        }
    }
</script>
