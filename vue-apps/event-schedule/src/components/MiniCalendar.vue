<template>
    <div class="MiniCalendar">
        <v-container fluid class="pa-0">
            <v-layout fluid wrap row>
                <v-flex xs12>
                    <v-layout fluid wrap row>

                        <v-flex lg1 offset-lg5 xs3 offset-xs0>
                            <v-text-field
                                    class="pa-0"
                                    placeholder="Año"
                                    v-model="dyear"
                                    ref="title"
                                    @change="changeDate"
                            >

                            </v-text-field>
                        </v-flex>
                        <v-flex lg1 offset-lg0 xs3 offset-xs1>
                            <v-select
                                    class="pa-0"
                                    placeholder="Mes"
                                    :items="['01','02','03','04','05','06','07','08','09','10','11','12']"
                                    v-model="dmonth"
                                    @change="changeDate"
                            >
                            </v-select>
                        </v-flex>

                        <v-flex lg1 offset-lg0 xs3 offset-xs1>
                            <loading-circular></loading-circular>
                        </v-flex>

                    </v-layout>

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
                            <template v-for="day in getRangeDays(range)">
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

        <modal title="" :showModal="getShowCalendarEventModal" @close="setShowCalendarEventModal(false)" :btn-close="true">
            <form-event v-if="getCalendarEventSelected" :calendars="getCalendars" v-model="getCalendarEventSelected"
                        :index="-1"/>
        </modal>
    </div>
</template>

<script>
    import {mapGetters, mapState,mapActions} from 'vuex';
    import MiniCalendarCell from './MiniCalendarCell.vue'
    import formEvent from './forms/form-event'
    import modal from './helpers/Modal'
    import LoadingCircular from './helpers/LoadingCircular'

    import moment from 'moment';
    import tz from 'moment-timezone'
    import 'moment/locale/es';
    import {extendMoment} from 'moment-range';


    export default {
        name: 'MiniCalendar',
        props: {
            events: {
                type: Array, default: function () {
                    return []
                }
            }
        },
        components: {MiniCalendarCell, formEvent, modal, LoadingCircular},
        data() {
            return {
                snackbar: false,
                eventDroped: null,
                dyear: null,
                dmonth: null,
                days: ['Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab', 'Dom']
            }
        },
        mounted: function () {
            this.dyear = this.getRealCalendarDate.format("YYYY")
            this.dmonth = this.getRealCalendarDate.format("MM")
        },
        methods: {
            ...mapActions([
                'setCalendarEventSelected',
                'setShowCalendarEventModal'
            ]),
            onEventDrop: function (event) {
                this.setCalendarEventSelected(event);
                this.setShowCalendarEventModal(true);

            },
            changeDate: function () {
                this.$store.commit('SET_CALENDAR_DATE', moment(this.dyear + this.dmonth, "YYYYMM"));
            },
            increaseMonth: function () {
                this.$store.commit('SET_CALENDAR_DATE', this.getCalendarDate.add(1, 'month'));
            },
            decreaseMonth: function () {
                this.$store.commit('SET_CALENDAR_DATE', this.getCalendarDate.subtract(1, 'month'));
            },
            getRangeDays: function (range) {
                let days = []
                for (let mday of range.by('days')) {
                    days.push(mday);
                }
                return days
            },
            isCurrentMonth: function (day) {
                if (day.format("MM") != this.getRealCalendarDate.format("MM")) {
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
            currentDate: function () {
                return this.date.get('date');
            },
            ...mapState({
                calendarDate: state => state.calendar.calendarDate,
                months: state => state.calendar.months,
                date: state => state.dates.date
            }),
            ...mapGetters([
                'getShowCalendarEventModal',
                'getCalendarEventSelected',
                'getRealDate',
                'getRealCalendarDate',
                'getCalendarYear',
                'getCalendarMonth',
                'getCalendars',
                'getCalendarDaysInMonth',
                'getMonthCalendar'
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
        height: 110px;
        border: 1px solid #8B8986;
        vertical-align: top;
    }

</style>
