<template>
    <div class="MiniCalendar">
        <v-container>
            <v-layout fluid>

                <v-flex xs-12>
                    <table class="table-calendar">
                        <thead>
                        <tr>
                            <th v-for="day in days" :key="'d'+day">{{day}}</th>

                        </tr>
                        </thead>

                        <tbody>

                        <tr v-for="(range,index) in getCalendar" :key="index">

                            <td v-for="day in getRangeDays(range)" :key="index+'_'+day">

                                {{day.format("DD")}}

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

    export default {
        name: 'MiniCalendar',
        props: [],
        components: {},
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
    .table-calendar {
        border: 1px solid #8B8986;
        border-spacing: 1px;
        width: 100%;
    }

    .table-calendar th {
        padding: 3px;
        border: 1px solid #8B8986;
    }
</style>
