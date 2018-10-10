<template>
    <div class="hello">
    </div>
</template>

<script>
    import {mapGetters, mapActions} from 'vuex';

    export default {
        name: 'SelectYear',
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
                'getLoading'
            ]),
        },
    }
</script>

<style scoped>

</style>
