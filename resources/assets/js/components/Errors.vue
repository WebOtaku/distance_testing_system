<template>

    <div class="errors" v-if="hasErrors">
        <ul class="errors-list">
            <template v-for="field in errors">
                <li class="error" style="color:red;" v-for="error in field">
                    {{ error }}
                </li>
            </template>
        </ul>
    </div>

</template>

<script>
    export default {
        props: ['errors'],
        computed: {
            hasErrors() {
                return Object.keys(this.$props.errors).length !== 0;
            }
        }
    }
</script>
