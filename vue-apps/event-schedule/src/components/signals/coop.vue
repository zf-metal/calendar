<template>
    <i v-if="enable" @click="filterCoop"
       class="material-icons signal-coop"
       data-toggle="tooltip"
       :title="getTitle">
        group
    </i>
</template>

<script>

    export default {
        name: 'coop',
        props: {
            enable: Boolean,
            count: Number,
            link: Number
        },
        components: {},
        data() {
            return {}
        },
        created: function () {
        },
        methods: {
            filterCoop: function(){
                this.$store.commit("SET_FILTER_COOP", this.link)
            }
        },
        computed: {
            getTitle: function(){
                return "Visita Cooperativa link: " + this.link;
            }
        },
    }
</script>

<style scoped>
    .signal-coop {
        color: red;
    }
</style>
