<template>
    <div class="ServiceView">
        <h4> {{getMonthName}} {{getYear}}</h4>
        <v-container fluid>
            <v-layout row wrap>
                <v-flex xs4>
                    <h5>Pendientess</h5>
                    <v-layout column>
                        <v-flex v-for="(colPreEvents, i) in preEvents" :key="i" xs12>
                            <h6>{{i}}</h6>
                            <mini-event v-for="(event, u) in colPreEvents" :key="u" :index="u" :event="event"></mini-event>

                        </v-flex>

                    </v-layout>
                </v-flex>
                <v-flex xs8 >
                    <span>Calendario</span>
                    "En Desarrollo..."
                </v-flex>
            </v-layout>
        </v-container>
    </div>
</template>

<script>
    import {mapGetters, mapState} from 'vuex';
    import {EventService} from '../resource'
    import moment from 'moment'
    import tz from 'moment-timezone'
    import 'moment/locale/es';

    import MiniEvent from "./MiniEvent.vue";

    export default {
        name: 'ServiceEvents',
        props: {
        },
        components: {MiniEvent},
        data() {
            return {
                preEvents: {},
                events: []
            }
        },
        mounted: function () {
            this.eventList();
        },
        methods: {
            eventList: function () {

                EventService.getServiceEvents(this.eventSelected.service, this.getFrom.format("YYYY-MM-DD"), this.getTo.format("YYYY-MM-DD")).then(
                    (response) => {
                        for (let i = 0; i < response.data.length; i++) {
                            let event = response.data[i];
                            var preEvents = {}
                            if (event.calendar != null) {
                                event.hour = moment(event.start).tz('America/Argentina/Buenos_Aires').format("HH:mm");
                                this.events.push(event);
                            } else {
                                let key = event.dateFrom + " <> " + event.dateTo;
                                if(!this.preEvents[key]){
                                    preEvents[key] = [];
                                }
                                preEvents[key].push(event);
                            }
                        }
                        this.preEvents = preEvents;
                    }
                )
            },
        },
        computed: {
            getFrom: function () {
                let from = moment(this.getYear + '-' + this.getMonth + '-01', "YYYY-MM-DD");
                return from.startOf('month');
            },
            getTo: function () {
                var to = this.getFrom.clone();
                return to.endOf('month')
            },
            ...mapState([
                'eventSelected',
            ]),
            ...mapGetters([
                'getYear',
                'getMonth',
                'getMonthName'
            ]),
        },
    }
</script>

<style scoped>

</style>
