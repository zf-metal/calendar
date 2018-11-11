<template>
    <div class="MiniCalendar">
        <v-container fluid class="pa-0">
            <v-layout fluid wrap row>
                <v-flex xs12>
                    <h4>{{year}} - {{month}}</h4>
                </v-flex>
                <v-flex xs12>
                    <table class="table-calendar">
                        <thead>
                        <tr>
                            <th v-for="day in days" :key="'d'+day">{{day}}</th>
                        </tr>
                        </thead>

                        <tbody>
                        <tr v-for="(range,index) in getMonthCalendar" :key="index">
                            <template v-for="day in getRangeDays(range)" >
                                <mini-calendar-cell
                                        :key="index+'_'+day"
                                        :day="day"
                                        :currentMonth="isCurrentMonth(day)"
                                        :events="getEventsByDay(day)"
                                        @eventDrop="onEventDrop"
                                >
                                </mini-calendar-cell>
                            </template>
                        </tr>
                        </tbody>
                    </table>
                </v-flex>

            </v-layout>
        </v-container>

        <modal title="" :showModal="snackbar" @close="snackbar = false" :btn-close="true">
            <form-event v-if="eventDroped" :calendars="getCalendars" v-model="eventDroped"
                        :index="-1" />
        </modal>
    </div>
</template>

<script>
    import {mapGetters, mapState} from 'vuex';
    import MiniCalendarCell from './MiniCalendarCell.vue'
    import formEvent from './forms/form-event'
    import modal from './helpers/Modal'
    export default {
        name: 'MiniCalendar',
        props: {
            events: {
                type: Array, default: function () {
                    return []
                }
            }
        },
        components: {MiniCalendarCell,formEvent,modal},
        data() {
            return {
                snackbar: false,
                eventDroped: null,
                today: null,
                dateContext: null,
                days: ['Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab', 'Dom']
            }
        },
        created: function () {
            this.today = this.date
            this.dateContext = this.date
        },
        methods: {
            onEventDrop: function(event){
                this.eventDroped = event
                this.snackbar = true

            },
            increaseMonth: function () {
                this.dateContext = moment(this.dateContext).add(1, 'month');
            },
            decreaseMonth: function () {
                this.dateContext = moment(this.dateContext).subtract(1, 'month');
            },
            getRangeDays: function (range) {
                let days = []
                for (let mday of range.by('days')) {
                    days.push(mday);
                }
                return days
            },
            isCurrentMonth: function (date) {
                if (date.format("MM") != this.dateContext.format("MM")) {
                    return false
                }
                return true
            },
            getEventsByDay: function (day) {
                let dayEvents = [];
                for (let i = 0; i < this.events.length; i++) {
                    let event = this.events[i];
                    if (event.start && event.start.substring(0, 10) == day.format("Y-MM-DD")) {
                        dayEvents.push(event)
                    }
                }
                return dayEvents
            }

        },
        computed: {
            year: function () {

                return this.dateContext.format('Y');
            },
            month: function () {

                return this.dateContext.format('MMMM');
            },
            daysInMonth: function () {
                return this.dateContext.daysInMonth();
            },
            currentDate: function () {
                return this.dateContext.get('date');
            },
            ...mapState([
                'date',
            ]),
            ...mapGetters([
                'getFirstDateOfMonth',
                'getEndDateOfMonth',
                'getMonthRange',
                'getDate',
                'getYear',
                'getMonth',
                'getMonthCalendar',
                'getWeeks',
                'getNumberOfWeeks',
                'getCalendars'
            ]),
        },
    }
</script>

<style scoped>


    .table-calendar {
        border: 1px solid #8B8986;
        border-spacing: 1px;
        width: 100%;
        table-layout: fixed;
    }

    .table-calendar th {
        padding: 3px;
        border: 1px solid #8B8986;
    }

    .table-calendar td {
        padding: 0;
        height: 75px;
        border: 1px solid #8B8986;
        vertical-align: top;
    }

</style>
