<template>

    <div class="edit_test">

        <h2>Редактироание теста</h2>

        <div class="test_info" v-if="testFetched">

            <div class="test_info__item">
                Название: {{ test.name }}
            </div>

            <div class="test_info__item">
                Тема: {{ test.theme.name }}
            </div>

            <div class="test_info__item">
                Колличество отображаемых вопросов: {{ test.number_questions }}
            </div>

            <div class="test_info__item">
                Статус:
                <button class="button" @click="changeTestState(test.active, test.id, $event)">
                    {{ test.active | fromBool }}
                </button>
            </div>

        </div>

        <section class="questions">

            <h3>Вопросы</h3>

            <router-link tag="div" :to="`/workspace/tests/edit/${this.testId}/question`" exact>
                <a class="is-link">Добавить вопрос</a>
            </router-link>

            <div class="question" v-for="(question, index) in questions">

                <div class="question__body">
                    {{ index + 1 }}. {{ question.question }}
                </div>

                <div class="answer_free" v-if="question.answer_free">
                    Ответ: <span>{{ question.answer_free.answer }}</span>
                </div>

                <div class="answer_variants" v-else-if="question.answer_variants.length">

                    <span>Ответы:</span>

                    <div class="answer"
                         v-for="answer in question.answer_variants"
                    >

                        <input type="radio" :name="`correct_answer_${index}`"
                               v-if="question.question_type_id === 1"
                               :checked="answer.correct_answer" disabled>

                        <input type="checkbox" :name="`correct_answer_${index}`"
                                v-if="question.question_type_id === 2"
                               :checked="answer.correct_answer" disabled>

                        <span>{{ answer.answer }}</span>

                    </div>

                </div>

                <button class="button" @click="deleteQuestion(index, question.id, $event)">Удалить</button>

            </div>

        </section>

        <router-link tag="div" to="/workspace/tests" exact>
            <a class="link link-back">Назад</a>
        </router-link>

    </div>

</template>

<script>
    import Question from '../../models/Question';
    import Test from '../../models/Test';

    export default {
        data() {
            return {
                testId: this.$route.params.testId,
                test: {},
                questions: []
            }
        },

        computed: {
            testFetched() {
                return Object.keys(this.test).length !== 0;
            }
        },

        methods: {
            deleteQuestion(index, questionId, $event) {
                $event.target.disabled = true;
                Question.destroy(questionId)
                    .then(() => {
                        this.questions.splice(index, 1);
                        $event.target.disabled = false;
                    });
            },

            changeTestState(value, testId, $event) {
                $event.target.disabled = true;
                Test.update(testId, !value, 'change_state')
                    .then(() => {
                        Vue.set(this.test, 'active', !value);
                        $event.target.disabled = false;
                    });
            },
        },

        filters: {
            fromBool(val) {
                return val ? 'Активен' : 'Не активен';
            }
        },

        created() {
            Question.fetchAll(this.testId, questions => {
                this.questions = questions;
            });

            Test.fetch(this.testId, test => {
                this.test = test;
            });
        }
    }
</script>
