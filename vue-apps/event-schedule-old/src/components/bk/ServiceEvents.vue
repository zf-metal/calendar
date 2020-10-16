<template>
    <div class="ServiceView">

        <service-detail></service-detail>

        <v-layout row wrap>
            <v-flex xs3>
                <h4>Pendientes {{preEvents.length}}</h4>
                <v-divider></v-divider>
                <v-layout column>
                    <v-flex v-for="(colPreEvents, i) in preEvents" :key="i" xs12>
                        <v-layout>
                            <v-flex lg5>
                                <v-list subheader>
                                    <v-list-tile>
                                        <v-list-tile-content>
                                            <v-list-tile-sub-title>Desde</v-list-tile-sub-title>
                                            <v-list-tile-title>{{ colPreEvents.from }}</v-list-tile-title>
                                        </v-list-tile-content>
                                    </v-list-tile>
                                    <v-list-tile>
                                        <v-list-tile-content>
                                            <v-list-tile-sub-title>Hasta</v-list-tile-sub-title>
                                            <v-list-tile-title>{{ colPreEvents.to }}</v-list-tile-title>
                                        </v-list-tile-content>
                                    </v-list-tile>
                                </v-list>

                            </v-flex>

                            <v-flex lg7 class="pt-1">
                                <mini-event v-for="(event, u) in colPreEvents.events" :key="u" :index="u"
                                            :event="event"></mini-event>
                            </v-flex>
                        </v-layout>
                        <v-divider></v-divider>


                    </v-flex>

                </v-layout>
            </v-flex>
            <v-flex xs9>
                <mini-calendar :events="events"></mini-calendar>
            </v-flex>
        </v-layout>


    </div>
</template>

<script>
    import {mapGetters, mapState} from 'vuex';
    import {EventService} from '../resource'
    import moment from 'moment'
    import tz from 'moment-timezone'
    import 'moment/locale/es';

    import MiniEvent from "./MiniEvent.vue";
    import MiniCalendar from './MiniCalendar.vue'
    import ServiceDetail from './ServiceDetail.vue'

    export default {
        name: 'ServiceEvents',
        props: {},
        components: {
            MiniCalendar,
            MiniEvent,
            ServiceDetail
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
            getFrom: function(){
                this.eventList()
            }

        },
        methods: {
            eventList: function () {

                EventService.getServiceEvents(
                    this.getServiceIdSelected,
                    this.getFrom.format("YYYY-MM-DD"),
                    this.getTo.format("YYYY-MM-DD")
                ).then(
                    (response) => {
                        let events = []
                        let preEvents = {}
                        for (let i = 0; i < response.data.length; i++) {
                            let event = response.data[i];

                            if (event.calendar != null) {
                                event.hour = moment(event.start).tz('America/Argentina/Buenos_Aires').format("HH:mm");
                                events.push(event);
                            } else {
                                let key = event.dateFrom + " <> " + event.dateTo;
                                let from = event.dateFrom;
                                let to = event.dateTo;
                                if (!this.preEvents[key]) {
                                    preEvents[key] = {from: from, to: to, events: []};
                                }
                                preEvents[key].events.push(event);
                            }
                        }
                        this.events = events;
                        this.preEvents = preEvents;
                    }
                )
            },
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
