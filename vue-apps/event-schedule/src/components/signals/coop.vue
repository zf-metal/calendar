<template>

    <v-btn small
           dark
           icon
           class="ma-0"
           v-if="enable"
           @click="goFilterCoop"
           v-tippy="{
                            dynamicTitle:true,
                            arrow:true,
                            performance:true,
                            placement:'top',
                            flip:true,
                            interactive: true,
                             animation: 'scale'
                        }"
           :title="getTitle"
    >
        <v-icon
                :color="getColor">
            group
        </v-icon>
    </v-btn>

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
                return "Visita Cooperativa link: " + this.link;
            },
            getColor: function () {
                if (this.link == this.filterCoop) {
                    return "yellow"
                }
                return "white"
            }

        },
    }
</script>
