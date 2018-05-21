<template>

    <div class="create_test">

        <h2>Создание теста</h2>

        <form method="POST" class="form">

            <!--CSRF-FIELD-->
            <slot name="csrf"></slot>

            <div class="form__group">
                <label for="theme_id">Тема</label>
                <select name="theme_id" id="theme_id"
                        aria-describedby="testTheme"
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
                <input type="text" name="name" id="name"
                       aria-describedby="testName"
                       v-model="test.name" required>
            </div>

            <div class="form__group">
                <label for="number_questions">Количество вопросов</label>
                <input type="number" name="number_questions"
                       id="number_questions" aria-describedby="testName"
                       min="1" max="99"
                       v-model="test.number_questions" required>
            </div>

            <!--ERRORS-->
            <div class="error" v-if="hasErrors">
                <ul>
                    <li v-for="error in errors" style="color:red;">
                        {{ error[0] }}
                    </li>
                </ul>
            </div>

            <button type="submit" class="btn btn-submit"
                    @click.prevent="createTest"
            >
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

    export default {
        data() {
            return {
                test: {
                    theme_id: 0,
                    name: '',
                    number_questions: 1
                },
                testId: 0,
                errors: {},
                testStatus: false,
                themes: [],
                themeStatus: false
            }
        },

        computed: {
            hasErrors() {
                return Object.keys(this.errors).length !== 0;
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
                this.themeStatus = true;
            });
        }
    }
</script>

<!--<div class="form__group">
    <label for="discipline">Дисциплина/МДК</label>
    <input type="text" name="discipline" id="discipline"
           aria-describedby="testDiscipline" required>
</div>

<div class="form__group">
    <label for="section">Раздел</label>
    <input type="text" name="section" id="section"
           aria-describedby="testSection" required>
</div>-->
