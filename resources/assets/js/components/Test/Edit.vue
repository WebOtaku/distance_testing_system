<template>

    <div class="edit_test">

        <section class="section">

            <h1 class="title">Редактирование теста</h1>

            <div class="notification is-primary" ref="notify" v-if="!hasErrors">
                <button class="delete" @click="closeNotify"></button>
                Тест был успешно обновлён
            </div>

            <div class="content" v-if="testFetched">

                <form method="POST" class="form">

                    <h4>Основная информация:</h4>

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

                    <h4 class="subtitle">Разбаловка:</h4>

                    <div class="field is-grouped score-scales">

                        <div class="field" v-for="(score_scale, index) in test.score_scales">

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

                    <div class="field status">

                        <label class="label" for="status">Статус:</label>

                        <div class="control">
                            <button :class="['button', 'is-success', {'is-outlined': !test.active}]" id="status"
                                    @click="changeTestState(test.active, test.id, $event)"
                            >
                                {{ test.active | fromBool }}
                            </button>
                        </div>

                    </div>

                    <!--ERRORS-->
                    <errors :errors="errors"></errors>

                    <div class="field is-grouped">

                        <div class="control">
                            <button type="submit" class="button is-primary"@click.prevent="updateTest">
                                Cохранить
                            </button>
                        </div>

                        <div class="control">
                            <router-link class="button is-link is-outlined" to="/workspace/tests" exact>
                                Назад
                            </router-link>
                        </div>

                    </div>

                </form>

            </div>

            <div class="content">

                <h4>Вопросы:</h4>

                <div class="field">
                    <div class="control">
                        <router-link class="button is-link is-outlined"
                             :to="`/workspace/tests/edit/${this.testId}/question`" exact
                        >
                            Добавить
                        </router-link>
                    </div>
                </div>

                <div class="content" v-for="(question, index) in questions">

                    <p>{{ index + 1 }}. {{ question.question }}</p>

                    <template v-if="question.answer_free">
                        <h6>Ответ: <span style="font-weight: normal;">
                            {{ question.answer_free.answer }}</span>
                        </h6>

                    </template>

                    <div class="content" v-else-if="question.answer_variants.length">

                        <h6>Ответы:</h6>

                        <div v-for="answer in question.answer_variants">

                            <input type="radio" :name="`correct_answer_${index}`"
                                   v-if="question.question_type_id === 1"
                                   :checked="answer.correct_answer" disabled>

                            <input type="checkbox" :name="`correct_answer_${index}`"
                                    v-if="question.question_type_id === 2"
                                   :checked="answer.correct_answer" disabled>

                            <span>{{ answer.answer }}</span>

                        </div>

                    </div>

                    <div class="field">
                        <div class="control">
                            <button class="button is-danger is-outlined"
                                    @click="deleteQuestion(index, question.id, $event)"
                            >
                                Удалить
                            </button>
                        </div>
                    </div>

                </div>

            </div>

        </section>

    </div>

</template>

<script>
    import Test from '../../models/Test';
    import Theme from '../../models/Theme';
    import Speciality from '../../models/Speciality';
    import Question from '../../models/Question';

    export default {
        data() {
            return {
                testId: this.$route.params.testId,
                test: {},
                questions: [],
                errors: {},
                themes: [],
                specialities: []
            }
        },

        computed: {
            testFetched() {
                return Object.keys(this.test).length !== 0;
            },

            hasErrors() {
                return Object.keys(this.errors).length !== 0;
            }
        },

        methods: {
            deleteQuestion(index, questionId, $event) {
                $event.target.disabled = true;
                Question.destroy(questionId, () => {
                    this.questions.splice(index, 1);
                    $event.target.disabled = false;
                });
            },

            changeTestState(value, testId, $event) {
                $event.target.disabled = true;
                $event.target.classList.add('is-loading');

                Test.update(!value, testId, 'change_state', () => {
                    Vue.set(this.test, 'active', !value);
                    $event.target.disabled = false;
                    $event.target.classList.remove('is-loading');
                });
            },

            updateTest($event) {
                $event.target.disabled = true;
                $event.target.classList.add('is-loading');

                Test.update(this.test, this.test.id, 'update_test', data => {
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
                        window.scrollTo(0, 0)
                    }
                });
            },

            fetchThemes() {
                Theme.fetchAll(themes => {
                    this.themes = themes;
                });
            },

            fetchSpecialities() {
                Speciality.fetchAll(specialities => {
                    this.specialities = specialities;
                });
            },

            fetchQuestions() {
                Question.fetchAll(this.testId, questions => {
                    this.questions = questions;
                });
            },

            fetchTest() {
                Test.fetch(this.testId, test => {
                    this.test = test;
                });
            },

            closeNotify() {
                this.$refs.notify.classList.remove('is-active');
            }
        },

        filters: {
            fromBool(val) {
                return val ? 'Активен' : 'Не активен';
            }
        },

        created() {
            this.fetchSpecialities();
            this.fetchThemes();
            this.fetchTest();
            this.fetchQuestions();
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

    .status {
        display: flex;
        align-items: center;
    }

    .status label {
        margin: 0 .8rem 0 0;
    }
</style>