<template>
    <td

            :class="{'not-current-month':!currentMonth}"
            class="pa-0"
    >
        <drop @drop="handleDrop" fill-height>
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
    import {mapState} from 'vuex';
    import MiniEvent from './MiniEvent'
    import {Drag, Drop} from 'vue-drag-drop';

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
                event.calendar = this.eventSelected.calendar
                // console.log("Fecha: ", this.day.format("Y-MM-DD"), " Hora:", moment(this.eventSelected.start).format("HH:mm"))
                event.start = this.day.format("Y-MM-DD") + " " + this.eventSelected.hour
                event.hour =  this.eventSelected.hour

                this.$emit("eventDrop", event)

            },
        },
        computed: {
            ...mapState([
                'eventSelected',
            ]),
        },
    }
</script>

<style scoped>

    .not-current-month {
        background-color: #8B8986;
    }
</style>
