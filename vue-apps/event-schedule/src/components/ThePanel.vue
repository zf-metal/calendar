<template>
    <div class="zfc-panel">
        <div style="height: 30px; z-index: 12; position: sticky; background-color: #ffffff;"></div>
        <div class="zfc-panel-child">
        <vue-tabs>
            <v-tab title="P">
                <filter-string></filter-string>
                <filterZone></filterZone>
                <filter-hour></filter-hour>
                <div class="zfc-panel-preevents">
                    <preEvent v-if="getPreEventsFiltered" v-for="(preEvent,index) in getPreEventsFiltered" :preEvent="preEvent"
                              :key="preEvent.id" :index="index">
                    </preEvent>
                </div>
            </v-tab>

            <v-tab title="C">
                <filter-calendars></filter-calendars>
            </v-tab>

            <v-tab title="F">
                <form-event :calendars="getCalendars"
                            v-model="eventSelected"
                            v-if="eventIndexSelected !=  null"
                            :index="eventIndexSelected"
                />
            </v-tab>

        </vue-tabs>
    </div>
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
        components: {
          preEvent, VueTabs, VTab, modal, filterZone,filterString, filterHour,formEvent, filterCalendars},
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