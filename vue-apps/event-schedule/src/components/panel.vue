<template>
    <div>

        <vue-tabs>
            <v-tab title="P">
                <h4>Visitas Pendientes</h4>

                <preEvent v-if="getPreEvents" v-for="(preEvent,index) in getPreEvents" :preEvent="preEvent"
                          :key="preEvent.id" :index="index">
                </preEvent>
            </v-tab>

            <v-tab title="Z">
                <h4>Visitas por Zona</h4>
                <button  class="btn btn-default material-icons" @click="showModalZone">filter_list</button>

                <modal :title="'Filtro de Zonas'" :showModal="showModal" @close="showModal = false">
                    <zone-filter></zone-filter>
                </modal>

                <div v-if="getPreEventsByZone" v-for="(zones,zoneName) in getPreEventsByZone" :key="zoneName">
                    <h6>{{zoneName}}</h6>

                    <preEvent v-for="(preEvent,index) in zones" :preEvent="preEvent"
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

            <v-tab title="S">
                <h4>Info Servicio</h4>
                <service :service="getServiceSelected"></service>
            </v-tab>
        </vue-tabs>

    </div>

</template>

<script>
    import {mapGetters, mapActions} from 'vuex';
    import preEvent from "./preEvent.vue";
    import zoneFilter from './zoneFilter.vue'
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
        components: {preEvent, checkCalendar, service, VueTabs, VTab, modal,zoneFilter},
        computed: {
            ...mapGetters([
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
        }
    }
</script>