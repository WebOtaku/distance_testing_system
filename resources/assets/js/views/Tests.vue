<template>
    <div class="tests">

        <h2>Тесты</h2>

        <div class="link-group">
            <router-link tag="div" to="/workspace/tests/create" exact>
                <a>Добавить</a>
            </router-link>

            <router-link tag="div" :to="`/workspace/tests/edit/${selectedTest}`" exact>
                <a>Редактировать</a>
            </router-link>
        </div>

        <table v-if="testStatus">
            <tr>
                <th></th>
                <th>Тема</th>
                <th>Название</th>
                <th>Количество вопросов</th>
                <th>Активный?</th>
            </tr>

            <tr v-for="(test, index) in tests"
                v-if="index < 6"
            >
                <td>
                    <input type="radio" name="test" :id="test.id"
                           class="test_selector" aria-describedby="testSelect"
                           v-model="selectedTest" :value="test.id">
                </td>

                <td v-for="(value, key) in test"
                    v-if="key !== 'id'"
                >
                    <template v-if="key !== 'active'">
                        {{ value }}
                    </template>

                    <template v-else>
                        <button class="btn" @click="changeTestState(index, value, test.id, $event)">
                            {{ value | fromBool }}
                        </button>
                    </template>
                </td>

                <td>
                    <button class="btn" @click="deleteTest(index, test.id, $event)">Удалить</button>
                </td>
            </tr>
        </table>
    </div>
</template>

<script>
    import Test from '../models/Test'

    export default {
        data() {
            return {
                tests: [],
                testStatus: false,
                selectedTest: ''
            }
        },

        methods: {
            changeTestState(index, value, testId, $event) {
                $event.target.disabled = true;
                Test.update(testId, !value, 'change_state')
                    .then(() => {
                        Vue.set(this.tests[index], 'active', !value);
                        $event.target.disabled = false;
                    });
            },

            deleteTest(index, testId, $event) {
                $event.target.disabled = true;
                Test.destroy(testId)
                    .then(() => {
                        this.tests.splice(index, 1);
                        $event.target.disabled = false;
                    });
            }
        },

        filters: {
            fromBool(val) {
                return val ? 'Активен' : 'Не активен';
            }
        },

        created() {
            Test.fetchAll(tests => {
                this.tests = tests;
                this.testStatus = true;
            });
        }
    }
</script>
