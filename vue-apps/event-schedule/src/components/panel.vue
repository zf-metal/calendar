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
                <h4><button class="btn btn-default btn-sm material-icons" @click="showModalZone">filter_list</button> Visitas por Zona  </h4>


                <modal :title="'Zonas'" :showModal="showModal" @close="showModal = false">
                    <zone-filter></zone-filter>
                    <div class="clearfix"></div>
                    <div class="text-right">
                        <button class="btn btn-primary text-center" type="button" style="margin:10px"
                                @click="closeModalZone">Ok
                        </button>
                    </div>
                </modal>

                <div v-if="!zone.hidden" v-for="zone in getZones" :key="zone.id">
                    <div v-if="getPreEventsByZone(zone.id).length > 0" >
                    <h6>{{zone.name}}</h6>
                    <preEvent  v-for="(preEvent,index) in getPreEventsByZone(zone.id)" :preEvent="preEvent"
                              :key="preEvent.id" :index="index">
                    </preEvent>
                    </div>
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
    components: {preEvent, checkCalendar, service, VueTabs, VTab, modal, zoneFilter},
    computed: {
      ...mapGetters([
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