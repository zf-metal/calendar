<template>
    <div>

        <vue-tabs>
            <v-tab title="P">
                <h4>Visitas Pendientes</h4>
                <preEvent v-if="getPreEvents" v-for="(preEvent,index) in getPreEvents" :preEvent="preEvent"
                          :key="preEvent.id" :index="index">
                </preEvent>
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
                <h4>Servicios</h4>
                <service :service="getServiceSelected"></service>
            </v-tab>
        </vue-tabs>

    </div>

</template>

<script>
  import {mapGetters, mapActions} from 'vuex';
  import preEvent from "./preEvent.vue";
  import checkCalendar from "./checkCalendar.vue"
  import service from "./service.vue"
  import {VueTabs, VTab} from 'vue-nav-tabs'
  //you can also import this in your style tag
  import 'vue-nav-tabs/themes/vue-tabs.css'

  export default {
    name: 'panel',
    components: {preEvent,checkCalendar,service,VueTabs,VTab},
    computed: {
      ...mapGetters([
        'getPreEvents',
        'hasCalendars',
        'getCalendars',
        'getServiceSelected'
      ]),
    }
  }
</script>