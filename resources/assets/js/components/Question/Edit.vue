<template>

    <div class="create-question">

        <section class="section" v-if="questionFetched">

            <h1 class="title">Редактирование вопроса</h1>

            <div class="notification is-primary" ref="notify" v-if="!hasErrors">
                <button class="delete" @click="closeNotify"></button>
                Вопрос был успешно обновлён
            </div>

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
                                   v-if="question.question_type_id === 1"
                                   @input="radioCheck(index)" :checked="answer.correct_answer" required>

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
                                @click.prevent="updateQuestion"
                        >
                            Сохранить
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
    import AnswerVariant from '../../models/AnswerVariant';

    export default {
        data() {
            return {
                questionId: this.$route.params.questionId,
                question: {},
                errors: {}
            }
        },

        computed: {
            questionFetched() {
                return Object.keys(this.question).length !== 0;
            },

            hasErrors() {
                return Object.keys(this.errors).length !== 0;
            }
        },

        methods: {
            updateQuestion($event) {
                $event.target.disabled = true;
                $event.target.classList.add('is-loading');

                Question.update(this.question, this.question.id, data => {
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
                let answer = this.question.answer_variants.find(x => x.id === index);

                if (!!answer) {
                    AnswerVariant.destroy(answer.id, () => {
                        this.question.answer_variants.splice(index, 1);
                    });
                }
                else {
                    this.question.answer_variants.splice(index, 1);
                }
            },

            closeNotify() {
                this.$refs.notify.classList.remove('is-active');
            },

            fetchQuestion() {
                Question.fetch(this.questionId, question => {
                    this.question = question;

                    if (question.question_type_id !== 3) {
                        Vue.set(this.question, 'answer_free', {
                            answer: ''
                        });
                    }
                    else {
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
                });
            }
        },

        created() {
            this.fetchQuestion();
        }
    }
</script>

<style lang="scss">
    .notification {
        min-width: 200px;
        width: 300px;
        max-width: 400px;
        display: none;
    }

    .notification.is-active {
        display: block;
    }

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
