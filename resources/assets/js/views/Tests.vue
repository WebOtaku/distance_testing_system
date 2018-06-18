<template>

    <div class="tests">

        <section class="section">

            <h1 class="title">Тесты</h1>

            <div class="page-controls">

                <form id="search" class="block is-inline-block" v-if="tests.length">

                    <div class="field">
                        <div class="control has-icons-left">
                            <input type="text" class="input" name="query" placeholder="Искать..."
                                   v-model="searchQuery">

                            <span class="icon is-small is-left">
                                <i class="fas fa-search"></i>
                            </span>
                        </div>
                    </div>

                </form>

                <router-link class="button is-link is-outlined block is-inline-block"
                             to="/workspace/tests/create" exact
                >
                    Добавить
                </router-link>

                <template v-if="tests.length">

                    <router-link class="button is-link is-outlined block is-inline-block"
                                 :to="`/workspace/tests/edit/${selectedTest}`" exact
                    >
                        Редактировать
                    </router-link>

                    <!-- TODO: Проверять есть ли вопросы у вабрнного теста если их нет не разрешать изменение статуса на активный -->

                    <button class="button is-success is-outlined block is-inline-block"
                            @click="changeTestState($event)"
                    >
                        Изменить статус
                    </button>

                    <!-- TODO: Сделать всплывающее окно для подтверждения удаления -->

                    <button class="button is-danger is-outlined block is-inline-block"
                            @click="deleteTest($event)"
                    >
                        Удалить
                    </button>

                </template>

            </div>

            <!-- TODO: Cделать колесо загрузки на страницах с таблицей -->

            <table-grid
                    v-if="tests.length"
                    :data="gridData"
                    :columns="gridColumns"
                    :filter-key="searchQuery"
                    @radioCheck="radioCheck"
            ></table-grid>

            <section class="section" v-else>
                <p>Список тестов пуст</p>
            </section>

            <!-- pagination bar -->
            <!-- v-bind 'setting' data to config page bar -->
            <!-- bind event 'page-change' to receive page info change -->
            <v-page :setting="pageSet"
                    @page-change="pageChange"
            ></v-page>

        </section>

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
                    pageSizeMenu: [10, 15, 20],
                    align: 'left'
                },
                searchQuery: '',
                gridColumns: [
                    'cпециальность',
                    'цикл',
                    'дисциплина',
                    'тема',
                    'название',
                    'количество вопросов',
                    'активный?'
                ],
                gridData: []

            }
        },

        methods: {
            changeTestState($event) {
                $event.target.disabled = true;
                $event.target.classList.add('is-loading');

                let testId = this.selectedTest;
                let index = this.tests.findIndex(x => x.id === testId);
                let value = this.tests[index].active;

                Test.update(!value, testId, 'change_state', () => {
                    Vue.set(this.tests[index], 'active', !value);
                    this.formationGridData(this.tests);
                    $event.target.classList.remove('is-loading');
                    $event.target.disabled = false;
                });
            },

            deleteTest($event) {
                $event.target.disabled = true;
                $event.target.classList.add('is-loading');

                let testId = this.selectedTest;
                let index = this.tests.findIndex(x => x.id === testId);

                Test.destroy(testId)
                    .then(() => {
                        this.tests.splice(index, 1);
                        this.pageSet.totalRow--;
                        this.formationGridData(this.tests);
                        $event.target.classList.remove('is-loading');
                        $event.target.disabled = false;
                    });
            },

            radioCheck(test_id) {
                this.selectedTest = test_id;
            },

            pageChange(pInfo) {
                Test.fetchAll(pInfo, data => {
                    this.tests = data.tests;

                    if (data.tests.length) {
                        this.selectedTest = data.tests[0].id;
                        this.formationGridData(data.tests);
                        this.pageSet.totalRow = data.totalRow;
                    }
                });
            },

            formationGridData(data) {
                this.gridData = [];
                data.forEach(x => {
                    this.gridData.push({
                        'id': x.id,
                        'cпециальность': x.speciality.code,
                        'цикл': x.theme.discipline_teacher.discipline.cicle.name,
                        'дисциплина': x.theme.discipline_teacher.discipline.name,
                        'тема': x.theme.name,
                        'название': x.name,
                        'количество вопросов': x.number_questions,
                        'активный?': x.active
                    });
                })
            },
        }
    }
</script>
