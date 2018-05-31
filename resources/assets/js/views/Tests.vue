<template>

    <div class="tests">

        <section class="section">

            <h1 class="title">
                Тесты
            </h1>

            <!-- pagination bar -->
            <!-- v-bind 'setting' data to config page bar -->
            <!-- bind event 'page-change' to receive page info change -->
            <v-page :setting="pageSet"
                    @page-change="pageChange"
            ></v-page>

            <form id="search" class="is-inline-block">

                <div class="field">
                    <label class="label">Искать в таблице</label>
                    <div class="control">
                        <input style="width: 300px" class="input" name="query" v-model="searchQuery" type="text">
                    </div>
                </div>

            </form>

            <div class="is-inline-block">

                <router-link tag="div" class="is-inline-block" to="/workspace/tests/create" exact>
                    <a class="button is-link is-outlined">Добавить</a>
                </router-link>

                <router-link tag="div" class="is-inline-block" :to="`/workspace/tests/edit/${selectedTest}`" exact>
                    <a class="button is-link is-outlined">Редактировать</a>
                </router-link>

                <button class="button is-primary is-outlined"
                        @click="changeTestState($event)"
                >
                    Изменить статус
                </button>

                <button class="button is-danger is-outlined"
                        @click="deleteTest($event)"
                >
                    Удалить
                </button>

            </div>

            <table-grid
                    :data="gridData"
                    :tests="tests"
                    :columns="gridColumns"
                    :filter-key="searchQuery"
                    @radioCheck="radioCheck"
            ></table-grid>

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
                    pageSizeMenu: [5, 10, 15],
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

                Test.update(testId, !value, 'change_state')
                    .then(() => {
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
            }
        },

        filters: {
            fromBool(val) {
                return val ? 'Активен' : 'Не активен';
            }
        }
    }
</script>
