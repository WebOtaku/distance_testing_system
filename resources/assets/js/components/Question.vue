<template>

    <div class="create_question">

        <h2>Добавление вопроса</h2>

        <form method="POST" class="form">

            <div class="form__group">
                <label for="question_type_id">Тип вопроса</label>
                <select name="question_type_id" id="question_type_id"
                        aria-describedby="questionType"
                        v-model="question.question_type_id" required
                >
                    <option :value="1">Строгий</option>
                    <option :value="2">Несколько вариантов ответа</option>
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
                    <input type="radio" name="correct_answer" v-if="question.question_type_id === 1"
                           @input="checkRadio(index)">

                    <input type="checkbox" name="correct_answer" v-if="question.question_type_id === 2"
                           v-model="answer.correct_answer">

                    <input type="text" name="answer" v-model="answer.answer">

                    <button class="btn" @click.prevent="deleteAnswer(index)">Удалить</button>
                </div>

                <button class="btn add_answer"
                        @click.prevent="addAnswer"
                >
                    Добавить ответ
                </button>

            </template>

            <!--ERRORS-->
            <div class="error" v-if="hasErrors">
                <ul>
                    <li v-for="error in errors" style="color:red;">
                        {{ error[0] }}
                    </li>
                </ul>
            </div>

            <button type="submit" class="btn btn-submit"
                    @click.prevent="addQuestion"
            >
                Cохранить
            </button>

        </form>

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
                    answers: []
                },

                errors: {}
            }
        },

        computed: {
            hasErrors() {
                return Object.keys(this.errors).length !== 0;
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

            checkRadio(index) {
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
