<template>

    <table class="table is-striped">

        <thead>

            <tr>
                <th></th>
                <th v-for="key in columns"
                    @click="sortBy(key)"
                    :class="{ active: sortKey === key }"
                >
                    {{ key | capitalize }}
                    <span class="arrow" :class="sortOrders[key] > 0 ? 'asc' : 'dsc'"></span>
                </th>
            </tr>

        </thead>

        <tbody>

            <tr v-for="(entry, index) in filteredData">

                <td>
                    <input type="radio" name="elem" :id="`elem_${index}`" aria-describedby="elemSelect"
                           @input.prevent="radioCheck(entry['id'])" :value="index" v-model="selectedElem"
                           v-if="index === 0" checked>

                    <input type="radio" name="elem" :id="`elem_${index}`" aria-describedby="elemSelect"
                           @input.prevent="radioCheck(entry['id'])" :value="index" v-model="selectedElem" v-else>
                </td>

                <td v-for="key in columns">

                    <template v-if="key === 'активный?'">
                        {{ entry[key] | fromBool }}
                    </template>
                    
                    <template v-else>
                        {{ entry[key] }}
                    </template>

                </td>

            </tr>

        </tbody>

    </table>

</template>

<script>
    export default {
        props: {
            tests: Array,
            data: Array,
            columns: Array,
            filterKey: String
        },
        data() {
            let sortOrders = {};

            this.columns.forEach(function (key) {
                sortOrders[key] = 1;
            });

            return {
                sortKey: '',
                sortOrders: sortOrders,
                selectedElem: 0
            }
        },
        computed: {
            filteredData: function () {
                let sortKey = this.sortKey;
                let filterKey = this.filterKey && this.filterKey.toLowerCase();
                let order = this.sortOrders[sortKey] || 1;
                let data = this.data;

                if (filterKey) {
                    data = data.filter(function (row) {
                        return Object.keys(row).some(function (key) {
                            return String(row[key]).toLowerCase().indexOf(filterKey) > -1;
                        })
                    })
                }

                if (sortKey) {
                    data = data.slice().sort(function (a, b) {
                        a = a[sortKey];
                        b = b[sortKey];
                        return (a === b ? 0 : a > b ? 1 : -1) * order;
                    })
                }

                this.changeSelectedTest(data);

                return data;
            }
        },
        filters: {
            capitalize: function (str) {
                return str.charAt(0).toUpperCase() + str.slice(1);
            },

            fromBool(val) {
                return val ? 'Активен' : 'Не активен';
            }
        },
        methods: {
            sortBy: function (key) {
                this.sortKey = key;
                this.sortOrders[key] = this.sortOrders[key] * -1;
            },

            radioCheck(elemId) {
                this.$emit('radioCheck', elemId);
            },

            changeSelectedTest(data) {
                if (data.length && !!data) {
                    if (this.selectedElem < data.length) {
                        let elemId = data.find((x, i) => i === this.selectedElem).id;
                        this.radioCheck(elemId);
                    }
                    else {
                        this.selectedElem = 0;
                        let elemId = data[0].id;
                        this.radioCheck(elemId);
                    }
                }
            }
        }
    }
</script>

<style lang="scss" scoped>
    th {
        cursor: default;
    }

    .arrow {
        display: inline-block;
        vertical-align: middle;
        width: 0;
        height: 0;
        margin-left: 5px;
        opacity: 1;
    }

    .arrow.asc {
        border-left: 6px solid transparent;
        border-right: 6px solid transparent;
        border-bottom: 6px solid #000000;
    }

    .arrow.dsc {
        border-left: 6px solid transparent;
        border-right: 6px solid transparent;
        border-top: 6px solid #000000;
    }
</style>