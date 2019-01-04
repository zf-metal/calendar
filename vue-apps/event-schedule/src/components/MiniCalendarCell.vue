<template>
    <td
            :class="{'not-current-month':!currentMonth}"
            class="pa-0"
    >
        <drop @drop="handleDrop" fill-height class="zfc-dropcell">
            <v-layout align-content-start wrap>
                <v-flex xs12 class="text-xs-right ">
                    {{day.format("DD")}}
                </v-flex>
                <v-flex xs12>
                    <mini-event v-for="(event,index) in events" :index="index" :event="event" :key="index"></mini-event>
                </v-flex>
            </v-layout>
        </drop>
    </td>
</template>

<script>
    import {mapState,mapGetters,mapActions} from 'vuex';
    import MiniEvent from './MiniEvent'
    import {Drag, Drop} from 'vue-drag-drop';
    import {calculateEnd} from './../utils/helpers'

    export default {
        name: 'MiniCalendarCell',
        props: {
            day: null,
            events: {type: Array, default: null},
            currentMonth: {type: Boolean, default: false},
        },
        components: {MiniEvent, Drag, Drop},
        methods: {
            handleDrop: function (data) {
                var event = data.event;


                let hour = (this.getHourSelected) ? this.getHourSelected : "00:00";
                event.start = this.day.format("Y-MM-DD") + " " + hour;
                event.hour = hour;
                event.end = calculateEnd(event.start, event.duration);

                event.calendar = this.getCalendarSelected;


                this.refreshEvent(event);


            },
            ...mapActions([
                'refreshEvent',
            ]),
        },
        computed: {
            ...mapState([
                'eventSelected'
            ]),
            ...mapGetters([
                'getCalendarSelected',
                'getHourSelected',
                'getEventIndexById'
            ])
        },
    }
</script>

<style scoped>

    .zfc-dropcell {
        height: 100%;
    }

    .not-current-month {
        background-color: #8B8986;
    }
</style>
