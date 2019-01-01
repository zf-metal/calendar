<template>
    <div class="ServiceView">

        <service-detail></service-detail>

        <v-layout row wrap>
            <v-flex xs3>
                <h4>Pendientes {{getPendingCalendarEvents.length}}</h4>

                <v-navigation-drawer
                        permanent
                        enable-resize-watcher
                            height="620"
                        class="ma-0"
                >


                    <div class=" pa-1" style="min-height:350px">
                        <v-layout column>
                            <preEvent v-for="(preEvent,index) in getPendingCalendarEvents"
                                      :preEvent="preEvent"
                                      :key="'pre'+preEvent.id" :index="index">
                            </preEvent>

                        </v-layout>
                    </div>

                </v-navigation-drawer>


            </v-flex>
            <v-flex xs9>
                <mini-calendar :events="getCalendarEvents"></mini-calendar>
            </v-flex>
        </v-layout>


    </div>
</template>

<script>
    import {mapGetters, mapState, mapActions} from 'vuex';
    import {EventService} from '../resource'
    import moment from 'moment'
    import tz from 'moment-timezone'
    import 'moment/locale/es';

    import MiniEvent from "./MiniEvent.vue";
    import MiniCalendar from './MiniCalendar.vue'
    import ServiceDetail from './ServiceDetail.vue'

    import PreEvent from './PreEvent'

    export default {
        name: 'ServiceEvents',
        props: {},
        components: {
            MiniCalendar,
            MiniEvent,
            ServiceDetail,
            PreEvent
        },
        data() {
            return {
                preEvents: {},
                events: [],
                dateContext: null
            }
        },
        mounted: function () {
            this.eventList();
        },
        watch: {
            getFrom: function () {
                this.eventList()
            }

        },
        methods: {
            eventList: function () {

                EventService.getEventsByServiceYearMonth(
                    this.getServiceIdSelected,
                    this.getCalendarYear,
                    this.getCalendarMonth
                ).then(
                    (response) => {
                        let events = []

                        for (let i = 0; i < response.data.length; i++) {
                            let event = response.data[i];

                            if (event.calendar != null) {
                                event.hour = moment(event.start).tz('America/Argentina/Buenos_Aires').format("HH:mm");
                            }
                            events.push(event);
                        }
                        this.setCalendarEvents(events);
                    }
                )
            },
            ...mapActions([
                'setCalendarEvents',
                'fetchEventsByServiceYearMonth',

            ])
        },
        computed: {
            getFrom: function () {
                let from = moment(this.getCalendarYear + '-' + this.getCalendarMonth + '-01', "YYYY-MM-DD");
                return from.startOf('month');
            },
            getTo: function () {
                let to = this.getFrom.clone();
                return to.endOf('month')
            },
            ...mapState([
                'eventSelected'
            ]),
            ...mapGetters([
                'getCalendarEvents',
                'getPendingCalendarEvents',
                'getServiceIdSelected',
                'getCalendarYear',
                'getCalendarMonth',
                'getMonthName',
                'getCalendars'
            ]),
        },
    }
</script>

<style scoped>

</style>
