<template>
    <div>
        <v-tabs v-model="active" color="grey lighten-4">
            <v-tab>P</v-tab>
            <v-tab>C</v-tab>
            <!--<v-tab>F</v-tab>-->

            <v-tab-item>
                <v-card flat>
                    <v-container fluid>
                        <v-layout row>
                            <v-flex xs3>
                                <filter-hour></filter-hour>
                            </v-flex>
                            <v-flex xs9>
                                <filter-string></filter-string>
                                <filterZone></filterZone>
                            </v-flex>
                        </v-layout>
                    </v-container>

                </v-card>

                <v-card flat>
                    <drop @drop="handleDrop">

                        <div class="zfc-panel-preevents pt-1" style="min-height:350px">
                            <preEvent v-if="getPreEventsFiltered" v-for="(preEvent,index) in getPreEventsFiltered"
                                      :preEvent="preEvent"
                                      :key="preEvent.id" :index="index">
                            </preEvent>
                        </div>
                    </drop>
                </v-card>
            </v-tab-item>

            <v-tab-item>
                <v-card flat>
                    <filter-calendars></filter-calendars>
                </v-card>
            </v-tab-item>


            <!--<v-tab-item>-->
                <!--<v-card flat>-->
                    <!--<form-event :calendars="getCalendars"-->
                                <!--v-model="eventSelected"-->
                                <!--v-if="eventIndexSelected !=  null"-->
                                <!--:index="eventIndexSelected"-->
                    <!--/>-->
                <!--</v-card>-->
            <!--</v-tab-item>-->

        </v-tabs>

    </div>
</template>

<script>
    import {mapState, mapGetters, mapActions} from 'vuex';
    import preEvent from "./preEvent.vue";
    import filterZone from './filters/filterZone.vue'
    import filterString from './filters/filterString.vue'
    import filterHour from './filters/filterHours.vue'
    import filterCalendars from "./filters/filterCalendars.vue"

    import modal from './helpers/modal.vue'
    import formEvent from './forms/form-event.vue'

    import {Drag, Drop} from 'vue-drag-drop';
    import {EventService} from '../resource'

    export default {
        name: 'panel',
        data() {
            return {
                showModal: false,
                active: null
            }
        },
        components: {
            preEvent, modal, filterZone, filterString, filterHour, formEvent, filterCalendars, Drag, Drop
        },
        computed: {
            ...mapState([
                'eventSelected',
                'eventIndexSelected'
            ]),
            ...mapGetters([
                'getPreEventsFiltered',
                'getZones',
                'getPreEventsByZone',
                'hasCalendars',
                'getCalendars',
                'getServiceSelected',
                'getEventIndexById'
            ]),
        },
        methods: {
            handleDrop: function (data) {

                let event = data.event
                event.calendar = null
                EventService.updateEvent(event).then(
                    (response) => {
                        this.$store.commit('REMOVE_EVENT', this.getEventIndexById(data.event.id));
                        this.$store.commit('ADD_PRE_EVENT', data.event);
                    }
                ).catch(
                    (error) => {
                        console.log("Error On Update Event");
                    }
                );
            },
            showModalZone: function () {
                this.showModal = true
            },
            closeModalZone: function () {
                this.showModal = false
            },
        }
    }
</script>

<style scoped>
    .zfc-panel {
        height: 95%;
        overflow: hidden;
    }

    .zfc-panel-child {
        height: 95%;
        overflow: auto;
    }

</style>