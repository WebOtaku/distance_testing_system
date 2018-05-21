<template>

    <div class="edit_test">

        <h2>Редактироание теста</h2>

        <router-link tag="div" :to="`/workspace/tests/edit/${this.testId}/question`" exact>
            <a class="link">Добавить вопрос</a>
        </router-link>

        <router-link tag="div" to="/workspace/tests" exact>
            <a class="link link-back">Назад</a>
        </router-link>

    </div>

</template>

<script>
    export default {
        data() {
            return {
                testId: this.$route.params.testId,
                questions: []
            }
        },

        methods: {

        }
    }
</script>
