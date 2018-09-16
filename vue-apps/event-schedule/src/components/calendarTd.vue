<template>
    <td class="zfc-column-calendar" :class="getClassDependingHour" :id="ki" :style="getCalendarTdStyle">
        <drop @drop="handleDrop" class="zfc-dropcell">
            <event v-for="(event,index) in getEventByTd(calendarId,start,end)"  :key="index"
                   :index="index" :event="event"
                   v-on:editEvent="onEditEvent">
            </event>
        </drop>
    </td>
</template>

<script>
    import {mapGetters, mapActions} from 'vuex';
    import {Drag, Drop} from 'vue-drag-drop';
    import {calculateEnd} from './../utils/helpers'
    import event from './event.vue'


    import moment from 'moment'
    import tz from 'moment-timezone'
    import 'moment/locale/es';

    export default {
        name: 'calnedarTd',
        props: ['calendarId', 'ki', 'name', 'date', 'hour', 'cellHeight', 'isNextDay', 'day'],
        components: {Drag, Drop,event},
        data() {
            return {
                top: 0,
                left: 0,
                upHere: false,
                start: null,
                end: null,
            }
        },
      mounted: function(){
        this.start = this.date+ " "+ this.hour;
        var end = moment(this.start, "YYYY-MM-DD HH:mm");
        end.add(30, "minutes");
        this.end = end.format("YYYY-MM-DD HH:mm");
      },
        computed: {
            ...mapGetters([
                'getCalendarSchedule',
                'getPreEventById',
                'getEventByTd',
                'getEventIndexById'
            ]),
            getCalendarTdStyle: function () {
                return "height:" + this.cellHeight + "px";
            },
            getClassDependingHour: function () {
                var schedule = this.getCalendarSchedule(this.calendarId, this.day);

                if (!schedule || (!schedule.start && !schedule.end)) {
                    return this.isNextDay == true ? 'zfc-hour-inactive-nd' : 'zfc-hour-inactive';
                }

                if ((this.hour >= schedule.start && this.hour < schedule.end) || (this.hour >= schedule.start2 && this.hour < schedule.end2)) {
                    return this.isNextDay == true ? 'zfc-hour-active-nd' : 'zfc-hour-active';
                }
                return this.isNextDay == true ? 'zfc-hour-inactive-nd' : 'zfc-hour-inactive';

            }
        },
        methods: {
            ...mapActions([
                'removePreEvent',
                'updateEvent',
                'pushEvent',
            ]),
            handleDrop: function (data) {
                var event = data.event;
                event.calendar = this.calendarId;
                event.start = this.date + " " + this.hour;
                event.end = calculateEnd(event.start, event.duration);
                event.hour = this.hour;

                if (data.op != undefined && data.op == 'push') {
                    this.$store.commit('REMOVE_PRE_EVENTS', this.getPreEventById(event.id));
                    this.pushEvent(event);
                }
                if (data.op != undefined && data.op == 'update') {
                    this.updateEvent({index: this.getEventIndexById(event.id), event: event});
                }
            },
            onEditEvent: function(){

            }


        },

    }
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>

    .zfc-column-calendar {
        width: 260px !important;
        min-width: 260px !important;
        max-width: 260px !important;
        position: relative;
    }

    .zfc-dropcell {
        height: 100%;
    }

    .zfc-hour-active {
        background-color: #fcfaee;
    }

    .zfc-hour-inactive {
        background-color: #a5a0a0;
    }

    .zfc-hour-active-nd {
        background-color: #faf5dd;
    }

    .zfc-hour-inactive-nd {
        background-color: #7c7878;
    }
</style>
