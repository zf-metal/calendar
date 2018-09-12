<template>
    <i v-if="enable" @click="goFilterCoop"
       class="material-icons" :class="getSignalKeepClass"
       data-toggle="tooltip"
       :title="getTitle">
        group
    </i>
</template>

<script>
    import {mapState} from 'vuex';

    export default {
        name: 'coop',
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
                return "Visita Cooperativa - Link: " + this.link;
            },
            getSignalKeepClass: function () {

                return "signal-signal-keep"

            }

        },
    }
</script>

<style scoped>
    .signal-keep {
        color: red;
    }
</style>
