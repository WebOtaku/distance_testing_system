<template>

    <div class="create_question">

        <h2>Добавление вопроса</h2>

        <form method="POST" class="form">

            <div class="form__group">
                <label for="question_type_id">Тип вопроса</label>
                <select name="question_type_id" id="question_type_id"
                        aria-describedby="questionType" @input="changeQuestionType($event)"
                        v-model="question.question_type_id" required
                >
                    <option :value="1">Строгий</option>
                    <option :value="2">Несколько вариантов ответа</option>
                    <option :value="3">Свободный</option>
                </select>
            </div>


            <div class="form__group">
                <label for="question">Текст вопроса</label>
                <textarea name="question" id="question" aria-describedby="questionText"
                          cols="60" rows="6" v-model="question.question" required></textarea>
            </div>

            <template v-if="question.question_type_id === 1 ||
                            question.question_type_id === 2"
            >

                <h3>Ответы</h3>

                <div class="form__group"
                     v-if="question.answers.length"
                     v-for="(answer, index) in question.answers"
                >
                    <input type="radio" name="correct_answer"
                           v-if="question.question_type_id === 1 && index === 0"
                           @input="radioCheck(index)" aria-describedby="correctAnswerSelector" checked required>

                    <input type="radio" name="correct_answer"
                           v-else-if="question.question_type_id === 1"
                           @input="radioCheck(index)" aria-describedby="correctAnswerSelector" required>

                    <input type="checkbox" name="correct_answer" v-if="question.question_type_id === 2"
                           v-model="answer.correct_answer" aria-describedby="correctAnswerSelector">

                    <input type="text" :name="`answer_body_${index}`" v-model="answer.answer" aria-describedby="answerBody" required>

                    <button class="btn btn-delete" v-if="index > 1"
                            @click.prevent="deleteAnswer(index)"
                    >
                        Удалить
                    </button>
                </div>

                <button class="btn btn-add"
                        @click.prevent="addAnswer"
                >
                    Добавить ответ
                </button>

            </template>

            <template v-if="question.question_type_id === 3">

                <h3>Ответ</h3>

                <div class="form__group">
                    <input type="text" name="answer_body" v-model="question.answer"
                           aria-describedby="answerBody" required>
                </div>

            </template>

            <!--ERRORS-->
            <errors :errors="errors"></errors>

            <button type="submit" class="btn btn-submit"
                    @click.prevent="addQuestion"
            >
                Cохранить
            </button>

        </form>

        <router-link tag="div" :to="`/workspace/tests/edit/${question.test_id}`" exact>
            <a class="link link-back">Назад</a>
        </router-link>

    </div>

</template>

<script>
    import Question from '../models/Question';

    export default {
        data() {
            return {
                question: {
                    test_id: this.$route.params.testId,
                    question_type_id: 1,
                    question: '',
                    answers: [
                        {
                            answer: '',
                            correct_answer: true
                        },
                        {
                            answer: '',
                            correct_answer: false
                        }
                    ]
                },
                errors: {}
            }
        },

        methods: {
            addQuestion($event) {
                $event.target.disabled = true;

                Question.store(this.question, data => {
                    if (!data.errors) {
                        document.location.href = `/workspace/tests/edit/${this.question.test_id}`;
                    }
                    else {
                        this.errors = data.errors;
                        $event.target.disabled = false;
                    }
                });
            },

            addAnswer() {
                if (this.question.answers.length < 6) {
                    this.question.answers.push({
                        answer: '',
                        correct_answer: false
                    });
                }
            },

            changeQuestionType($event) {
                let type = Number.parseInt($event.target.value);

                this.errors = {};

                if (type === 3) {
                    delete this.question.answers;
                    Vue.set(this.question, 'answer', '');
                }
                else {
                    delete this.question.answer;

                    Vue.set(this.question, 'answers', [
                        {
                            answer: '',
                            correct_answer: true
                        },
                        {
                            answer: '',
                            correct_answer: false
                        }
                    ]);
                }
            },

            radioCheck(index) {
                this.question.answers.forEach((x, i) => {
                    x.correct_answer = i === index;
                });
            },

            deleteAnswer(index) {
                this.question.answers.splice(index, 1);
            }
        }
    }
</script>
