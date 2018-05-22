<template>

    <div class="edit_test">

        <h2>Редактироание теста</h2>

        <section class="questions">

            <h3>Вопросы</h3>

            <router-link tag="div" :to="`/workspace/tests/edit/${this.testId}/question`" exact>
                <a class="link">Добавить вопрос</a>
            </router-link>

            <div class="question" v-for="(question, index) in questions">

                <div class="question__body">
                    {{ index + 1 }}. {{ question.question }}
                </div>


                <div class="answers" v-if="question.answer_variants.length">

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

                <button class="btn" @click="deleteQuestion(index, question.id, $event)">Удалить</button>

            </div>

        </section>

        <router-link tag="div" to="/workspace/tests" exact>
            <a class="link link-back">Назад</a>
        </router-link>

    </div>

</template>

<script>
    import Question from '../../models/Question';

    export default {
        data() {
            return {
                testId: this.$route.params.testId,
                questions: []
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
            }
        },

        created() {
            Question.fetchAll(this.testId, questions => {
                this.questions = questions;
            });
        }
    }
</script>
