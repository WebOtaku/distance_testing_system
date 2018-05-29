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

        <!-- pagination bar -->
        <!-- v-bind 'setting' data to config page bar -->
        <!-- bind event 'page-change' to receive page info change -->
        <v-page :setting="pageSet"
                @page-change="pageChange"
        ></v-page>

        <table v-if="tests.length">

            <tr>
                <th></th>
                <th>Название</th>
                <th>Тема</th>
                <th>Количество вопросов</th>
                <th>Активный?</th>
            </tr>

            <tr v-for="(test, index) in tests">

                <td>
                    <input type="radio" name="test" class="test_selector" :id="`test_${index}`"
                           aria-describedby="testSelect" @input.prevent="radioCheck(test.id)"
                           v-if="index === 0" checked>

                    <input type="radio" name="test" class="test_selector" :id="`test_${index}`"
                           aria-describedby="testSelect" @input.prevent="radioCheck(test.id)" v-else>
                </td>

                <td>
                    {{ test.name }}
                </td>

                <td>
                    {{ test.theme.name }}
                </td>

                <td>
                    {{ test.number_questions }}
                </td>

                <td>
                    <button class="btn" @click="changeTestState(index, test.active, test.id, $event)">
                        {{ test.active | fromBool }}
                    </button>
                </td>

                <td>
                    <button class="btn" @click="deleteTest(index, test.id, $event)">Удалить</button>
                </td>

            </tr>

        </table>

    </div>

</template>

<script>
    import Test from '../models/Test';

    export default {
        data() {
            return {
                tests: [],
                selectedTest: 0,
                pageSet: {
                    totalRow: 0,
                    language: 'ru',
                    pageSizeMenu: [5, 10, 15],
                    align: 'left'
                }
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
                        this.pageSet.totalRow--;
                        $event.target.disabled = false;
                    });
            },

            radioCheck(testId) {
                this.selectedTest = testId;
            },

            pageChange(pInfo) {
                Test.fetchAll(pInfo, data => {
                    this.tests = data.tests;
                    this.selectedTest = data.tests[0].id;
                    this.pageSet.totalRow = data.totalRow;
                });
            }
        },

        filters: {
            fromBool(val) {
                return val ? 'Активен' : 'Не активен';
            }
        }
    }
</script>
