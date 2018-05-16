<template>
    <div class="tests">
        <table v-if="testStatus">
            <tr>
                <th>Тема</th>
                <th>Название</th>
                <th>Количество вопросов</th>
                <th>Активный?</th>
            </tr>

            <tr v-for="test in tests">
                <td v-for="val in test">
                    {{ val }}
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
                testStatus: false
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
