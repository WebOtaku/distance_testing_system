<template>

    <div class="create_test columns">

        <h2>Создание теста</h2>

        <form method="POST" class="form">

            <fieldset class="basic_information">

                <legend>Основная информация</legend>

                <div class="form__group">
                    <label for="speciality_id">Специальность</label>
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

                <div class="form__group">
                    <label for="theme_id">Тема</label>
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

                <div class="form__group">
                    <label for="name">Название</label>
                    <input type="text" name="name" id="name" aria-describedby="testName"
                           v-model="test.name" required>
                </div>

                <div class="form__group">
                    <label for="number_questions">Количество вопросов</label>
                    <input type="number" name="number_questions" id="number_questions"
                           aria-describedby="testName" min="1" max="99"
                           v-model="test.number_questions" required>
                </div>

            </fieldset>

            <fieldset class="score_scales">

                <legend>Разбалловка</legend>

                <div class="form__group score_scale"
                     v-for="(score_scale, index) in test.score_scales"
                >

                    <span v-html="score_scale.score" aria-describedby="score"></span> :

                    от <input type="number" :name="`score_scale_from_${index}`"
                              min="1" max="99" aria-describedby="scaleFrom"
                              v-model="score_scale.from">

                    до <input type="number" :name="`score_scale_to_${index}`"
                              min="1" max="99" aria-describedby="scaleTo"
                              v-model="score_scale.to">

                </div>

            </fieldset>

            <!--ERRORS-->
            <errors :errors="errors"></errors>

            <button type="submit" class="btn btn-submit" @click.prevent="createTest">
                Cохранить
            </button>

            <router-link tag="div" to="/workspace/tests" exact>
                <a class="link link-back">Назад</a>
            </router-link>

        </form>

    </div>

</template>

<script>
    import Theme from '../../models/Theme';
    import Test from '../../models/Test';
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
            }
        },

        created() {
            Theme.fetchAll(themes => {
                this.themes = themes;
                this.test.theme_id = themes[0].id;
            });

            Speciality.fetchAll(specialities => {
                this.specialities = specialities;
                this.test.speciality_id = specialities[0].id;
            });
        }
    }
</script>
