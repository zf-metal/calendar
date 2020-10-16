<template>
    <v-toolbar
            app
            :clipped-left="clipped"
    >
        <v-toolbar-side-icon @click.stop="drawer = !drawer"></v-toolbar-side-icon>
        <v-toolbar-title v-text="title"></v-toolbar-title>
        <v-btn icon>
            <v-icon>home</v-icon>
        </v-btn>
        <v-spacer></v-spacer>


    </v-toolbar>

</template>

<script>
    import {mapState, mapGetters, mapActions} from 'vuex';
    import day from './DaySelect.vue'
    import loading from './helpers/loading.vue'

    export default {
        name: 'navi',
        components: {day, loading},
        props: {
            drawer: Boolean,
            clipped: Boolean,
            title: String
        },
        data() {
            return {
                myCellHeight: 60,
                start: '00:00'
            }
        },
        created: function () {
            this.myCellHeight = this.cellHeight;
            this.start = this.calendarStart;
        },
        methods: {
            applyCellHeight: function () {
                this.$store.commit('SET_CELL_HEIGHT', this.myCellHeight);
            },
            changeCalendarStart: function () {
                this.$store.commit('SET_CALENDAR_START', this.start);
            }
        },
        computed: {
            ...mapState([
                'cellHeight',
                'loading',
                'calendarStart'
            ]),
            ...mapGetters([
                'getDayName',
                'getDate',
            ]),
        },
    }
</script>