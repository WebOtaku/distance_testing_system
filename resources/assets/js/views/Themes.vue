<template>

    <div class="themes">

        <section class="section">

            <h1 class="title">
                Темы
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
                        <input class="input" name="query" v-model="searchQuery" type="text">
                    </div>
                </div>

            </form>

            <div class="is-inline-block">

                <router-link tag="div" class="is-inline-block" to="/workspace/themes/create" exact>
                    <a class="button is-link is-outlined">Добавить</a>
                </router-link>

                <button class="button is-danger is-outlined"
                        @click="deleteTheme($event)"
                >
                    Удалить
                </button>

            </div>

            <table-grid
                    :data="gridData"
                    :columns="gridColumns"
                    :filter-key="searchQuery"
                    @radioCheck="radioCheck"
            ></table-grid>

        </section>

    </div>

</template>

<script>
    import Theme from '../models/Theme'

    export default {
        data() {
            return {
                themes: [],
                selectedTheme: 0,
                pageSet: {
                    totalRow: 0,
                    language: 'ru',
                    pageSizeMenu: [10, 15, 20],
                    align: 'left'
                },
                searchQuery: '',
                gridColumns: [
                    'цикл',
                    'дисциплина',
                    'название',
                    'курс'
                ],
                gridData: []
            }
        },

        methods: {
            deleteTheme($event) {
                $event.target.disabled = true;
                $event.target.classList.add('is-loading');

                let themeId = this.selectedTheme;
                let index = this.themes.findIndex(x => x.id === themeId);

                Theme.destroy(themeId)
                    .then(() => {
                        this.themes.splice(index, 1);
                        this.pageSet.totalRow--;
                        this.formationGridData(this.themes);
                        $event.target.classList.remove('is-loading');
                        $event.target.disabled = false;
                    });
            },

            radioCheck(test_id) {
                this.selectedTheme = test_id;
            },

            pageChange(pInfo) {
                Theme.fetchPag(pInfo, data => {
                    this.themes = data.themes;

                    if (data.themes.length) {
                        this.selectedTest = data.themes[0].id;
                        this.formationGridData(data.themes);
                        this.pageSet.totalRow = data.totalRow;
                    }
                }, 'getPagination');
            },

            formationGridData(data) {
                this.gridData = [];
                data.forEach(x => {
                    this.gridData.push({
                        'id': x.id,
                        'цикл': x.discipline_teacher.discipline.cicle.name,
                        'дисциплина': x.discipline_teacher.discipline.name,
                        'название': x.name,
                        'курс': x.course
                });
                })
            }
        }
    }
</script>
