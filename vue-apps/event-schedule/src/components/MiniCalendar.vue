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

                        <tr v-for="(range,index) in getCalendar" :key="index">

                            <td
                                    v-for="day in getRangeDays(range)"
                                    :key="index+'_'+day"
                                    :class="{'not-current-month':!isCurrentMonth(day)}"
                                    class="pa-0"
                            >
                                <v-layout align-content-start wrap>
                                <v-flex xs12 class="text-xs-right ">
                                    {{day.format("DD")}}
                                </v-flex>
                                    <v-flex xs12>
                                <mini-calendar-cell :events="getEventsByDay(day)"></mini-calendar-cell>
                                    </v-flex>
                                </v-layout>
                            </td>
                        </tr>

                        </tbody>


                    </table>
                </v-flex>

            </v-layout>
        </v-container>
    </div>
</template>

<script>
    import {mapGetters, mapState} from 'vuex';
    import MiniCalendarCell from './MiniCalendarCell.vue'

    export default {
        name: 'MiniCalendar',
        props: {
            events: {
                type: Array, default: function () {
                    return []
                }
            }
        },
        components: {MiniCalendarCell},
        data() {
            return {
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
                'getCalendar',
                'getWeeks',
                'getNumberOfWeeks'
            ]),
        },
    }
</script>

<style scoped>

    .not-current-month {
        background-color: #8B8986;
    }

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
