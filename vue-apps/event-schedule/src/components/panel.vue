<template>
    <div>
        <vue-tabs>
            <v-tab title="P">
                <h4>Visitas Pendientes</h4>
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


        </vue-tabs>
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

    export default {
        name: 'panel',
        data() {
            return {
                showModal: false,
            }
        },
        components: {preEvent, checkCalendar, service, VueTabs, VTab, modal, filterZone,filterString},
        computed: {
            ...mapGetters([
                'getPreEventsFiltered',
                'getZones',
                'getPreEventsByZone',
                'getPreEvents',
                'hasCalendars',
                'getCalendars',
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
    .zfc-panel-preevents {
        height: 700px;
        overflow: auto;
    }
</style>