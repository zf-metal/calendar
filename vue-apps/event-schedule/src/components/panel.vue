<template>
    <div class="zfc-panel">
        <div style="height: 30px; z-index: 12; position: sticky; background-color: #ffffff;"></div>
        <div class="zfc-panel-child">
        <vue-tabs>
            <v-tab title="P">
                <filter-string></filter-string>
                <filterZone></filterZone>
                <div class="zfc-panel-preevents">
                    <preEvent v-if="getPreEventsFiltered" v-for="(preEvent,index) in getPreEventsFiltered" :preEvent="preEvent"
                              :key="preEvent.id" :index="index">
                    </preEvent>
                </div>
            </v-tab>

            <v-tab title="C">
                <h4>Calendarios</h4>
                <check-calendar
                        v-if="hasCalendars"
                        v-for="(calendar,index) in getCalendars" :key="index"
                        :index="index" :name="calendar.name" :id="calendar.id"

                ></check-calendar>
            </v-tab>

            <v-tab title="F">
                <form-event :calendars="getCalendars"
                            v-model="getEventSelected"
                            v-if="getEventIndexSelected !=  null"
                            :index="getEventIndexSelected"
                />
            </v-tab>

        </vue-tabs>
    </div>
    </div>
</template>

<script>
    import {mapGetters, mapActions} from 'vuex';
    import preEvent from "./preEvent.vue";
    import filterZone from './filterZone.vue'
    import filterString from './filterString.vue'

    import checkCalendar from "./checkCalendar.vue"
    import service from "./service.vue"
    import modal from './helpers/modal.vue'
    import {VueTabs, VTab} from 'vue-nav-tabs'
    import 'vue-nav-tabs/themes/vue-tabs.css'
    import formEvent from './forms/form-event.vue'

    export default {
        name: 'panel',
        data() {
            return {
                showModal: false,
            }
        },
        components: {preEvent, checkCalendar, service, VueTabs, VTab, modal, filterZone,filterString,formEvent},
        computed: {
            ...mapGetters([
                'getPreEventsFiltered',
                'getZones',
                'getPreEventsByZone',
                'getPreEvents',
                'hasCalendars',
                'getCalendars',
                'getEventSelected',
                'getEventIndexSelected',
                'getServiceSelected'
            ]),
        },
        methods: {
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
    .zfc-panel{
        height: 95%;
        overflow: hidden;
    }

    .zfc-panel-child{
        height: 95%;
        overflow: auto;
    }

</style>