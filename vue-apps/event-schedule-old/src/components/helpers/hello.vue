<template>
    <div class="hello">
    </div>
</template>

<script>
    import {mapGetters, mapActions} from 'vuex';

    export default {
        name: 'hello',
        props:[],
        components: {},
        data() {
            return {
                asd: {}
            }
        },
        created: function () {
        },
        methods: {},
        computed: {
            ...mapGetters([
            ]),
        },
    }
</script>

<style scoped>

</style>
