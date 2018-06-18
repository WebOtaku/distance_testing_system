<template>

    <div class="create-question">

        <section class="section">

            <h1 class="title">Добавление вопроса</h1>

            <form method="POST" class="form">

                <div class="field">
                    <label class="label" for="question_type_id">Тип вопроса</label>

                    <div class="select">
                        <select name="question_type_id" id="question_type_id"
                                v-model="question.question_type_id" required
                        >
                            <option :value="1">Строгий</option>
                            <option :value="2">Несколько вариантов ответа</option>
                            <option :value="3">Свободный</option>
                        </select>
                    </div>
                </div>


                <div class="field">
                    <label class="label" for="question">Текст вопроса</label>

                    <div class="control">
                        <textarea class="textarea" name="question" id="question"
                                  rows="4" v-model="question.question" required></textarea>
                    </div>
                </div>

                <div class="content" v-if="question.question_type_id === 1
                                           || question.question_type_id === 2"
                >
                    <h6>Ответы:</h6>

                    <div class="field">
                        <div class="control">
                            <button class="button is-link is-outlined" @click.prevent="addAnswer">
                                Добавить
                            </button>
                        </div>
                    </div>

                    <div class="field answers" v-if="question.answer_variants.length"
                         v-for="(answer, index) in question.answer_variants"
                    >

                        <div class="control is-grouped answer">
                            <input type="radio" name="correct_answer"
                                   v-if="question.question_type_id === 1 && index === 0"
                                   @input="radioCheck(index)" checked required>

                            <input type="radio" name="correct_answer"
                                   v-else-if="question.question_type_id === 1"
                                   @input="radioCheck(index)" required>

                            <input type="checkbox" name="correct_answer"
                                   v-if="question.question_type_id === 2"
                                   v-model="answer.correct_answer">

                            <input type="text" class="input"
                                   v-model="answer.answer" required>

                            <button class="button is-danger is-outlined"
                                    v-if="index > 1"
                                    @click.prevent="deleteAnswer(index)"
                            >
                                Удалить
                            </button>
                        </div>

                    </div>

                </div>

                <div class="content" v-if="question.question_type_id === 3">

                    <h6>Ответ:</h6>

                    <div class="field">
                        <div class="control">
                            <input type="text" class="input" name="answer_body"
                                   v-model="question.answer_free.answer" required>
                        </div>
                    </div>

                </div>

                <!--ERRORS-->
                <errors :errors="errors"></errors>

                <div class="field is-grouped">
                    <div class="control">
                        <button type="submit" class="button is-primary"
                                @click.prevent="addQuestion"
                        >
                            Добавить
                        </button>
                    </div>

                    <div class="control">
                        <router-link class="button is-link is-outlined"
                                     :to="`/workspace/tests/edit/${question.test_id}`" exact
                        >
                            Назад
                        </router-link>
                    </div>
                </div>

            </form>

        </section>

    </div>

</template>

<script>
    import Question from '../../models/Question';

    export default {
        data() {
            return {
                question: {
                    test_id: this.$route.params.testId,
                    question_type_id: 1,
                    question: '',
                    answer_free: {
                        answer: ''
                    },
                    answer_variants: [
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
                $event.target.classList.add('is-loading');

                Question.store(this.question, data => {
                    if (!data.errors) {
                        $event.target.disabled = false;
                        $event.target.classList.remove('is-loading');
                        document.location.href = `/workspace/tests/edit/${this.question.test_id}`;
                    }
                    else {
                        this.errors = data.errors;
                        $event.target.disabled = false;
                        $event.target.classList.remove('is-loading');
                    }
                });
            },

            addAnswer() {
                if (this.question.answer_variants.length < 6) {
                    this.question.answer_variants.push({
                        answer: '',
                        correct_answer: false
                    });
                }
            },

            radioCheck(index) {
                this.question.answer_variants.forEach((x, i) => {
                    x.correct_answer = i === index;
                });
            },

            deleteAnswer(index) {
                this.question.answer_variants.splice(index, 1);
            },
        }
    }
</script>

<style lang="scss">
    .field .control textarea.textarea {
        min-width: 231px;
        width: 100%;
        max-width: 500px;
    }

    .answer {
        display: flex;
        align-items: center;
    }

    .answer input[type = radio],
    .answer input[type = checkbox] {
        margin-right: 0.5rem;
    }

    .answer button {
        margin-left: 0.5rem;
    }
</style>

/*changeQuestionType($event) {
    let type = Number.parseInt($event.target.value);

    this.errors = {};

    if (type === 3) {
        delete this.question.answer_variants;
        Vue.set(this.question, 'answer_free', '');
    }
    else {
        delete this.question.answer_free;

        Vue.set(this.question, 'answer_variants', [
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
},*/
