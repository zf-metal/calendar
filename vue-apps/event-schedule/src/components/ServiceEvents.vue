<template>
    <div class="ServiceView">
    </div>
</template>

<script>
    import {mapGetters, mapActions} from 'vuex';

    export default {
        name: 'ServiceEvents',
        props: {
            service: Number,
            date: String
        },
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
