<template>

    <v-toolbar-items class="hidden-sm-and-down">
        <v-btn icon @click="before">
            <v-icon>navigate_before</v-icon>
        </v-btn>

        <v-menu
                ref="menuDate"
                v-model="menu"
                :nudge-right="40"
                lazy
                transition="scale-transition"
                offset-y
                full-width
                min-width="290px"
        >


            <v-btn   slot="activator">
                {{date}}
            </v-btn>

            <v-date-picker v-model="date" >

            </v-date-picker>

        </v-menu>

        <v-btn icon @click="next">
            <v-icon>navigate_next</v-icon>
        </v-btn>


    </v-toolbar-items>

</template>

<script>
    import {mapGetters, mapActions} from 'vuex';
    import holiday from './signals/holiday.vue'
    import moment from 'moment'
    import momenttz from 'moment-timezone'
    import 'moment/locale/es';

    export default {
        name: 'DaySelect',
        props: ['value'],
        components: {holiday},
        data() {
            return {
                menu: false,
                date: '',
                wdate: ''
            }
        },
        created: function () {
            this.date = this.value;
            this.wdate = this.date
        },
        watch: {
          date: function(){
              this.onChange()
          }
        },
        computed: {
            ...mapGetters([
                'getMonthName',
                'getDayName',
                'getNumberOfDayInMonthOrdinal',
                'isHoliday'
            ]),
            getLoading: function () {
                //TODO
                return false;
            }
        },
        methods: {
            ...mapActions([
                'changeDate',
                'checkOutOfService'
            ]),
            before: function () {
                if (this.getLoading == 0) {
                    var d = moment(this.date)
                    d.subtract(1, 'day')
                    this.date = d.tz('America/Argentina/Buenos_Aires').format("YYYY-MM-DD")
                    // this.changeDate(this.date)
                }
            },
            next: function () {
                if (this.getLoading == 0) {
                    var d = moment(this.date)
                    d.add(1, 'day')
                    this.date = d.tz('America/Argentina/Buenos_Aires').format("YYYY-MM-DD")
                    console.log(this.date)
                    // this.changeDate(this.date)
                }
            },
            onChange: function () {
                var d = moment(this.date)
                this.changeDate(d)

            },
            getDate: function () {
                return this.date.tz('America/Argentina/Buenos_Aires').format("YYYY-MM-DD")
            }
        }
    }
</script>

<style scoped>
    .holiday {
        color: darkred;
    }

</style>