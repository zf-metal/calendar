<template>

    <i v-if="enable" @click="goFilterCoop"
       class="material-icons pull-right" :class="getSignalCoopClass"
       data-toggle="tooltip"
       :title="getTitle">
        group
    </i>

</template>

<script>
    import {mapState} from 'vuex';

    export default {
        name: 'keep',
        props: {
            enable: Boolean,
            count: Number,
            link: Number
        },
        methods: {
            goFilterCoop: function () {
                if (this.link == this.filterCoop) {
                    this.$store.commit("SET_FILTER_COOP", null)
                } else {
                    this.$store.commit("SET_FILTER_COOP", this.link)
                }

            }
        },
        computed: {
            ...mapState([
                'filterCoop',
            ]),
            getTitle: function () {
                return "Visita Cooperativa link: " + this.link;
            },
            getSignalCoopClass: function () {
                if (this.link == this.filterCoop) {
                    return "signal-coop-enable"
                } else {
                    return "signal-coop"
                }
            }

        },
    }
</script>

<style scoped>
    .signal-coop {
        color: red;
    }

    .signal-coop-enable {
        color: green;
    }
</style>
