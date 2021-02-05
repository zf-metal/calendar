<template>
  <div>
    <v-tabs v-model="active" color="grey lighten-4">
      <v-tab>
        <v-icon>event</v-icon>
      </v-tab>
      <v-tab>
        <v-icon>assignment_ind</v-icon>
      </v-tab>
      <v-tab>
        <v-icon>search</v-icon>
      </v-tab>
      <!--<v-tab>F</v-tab>-->

      <v-tab-item>
        <v-card flat>
          <v-container fluid class="pa-1">
            <v-layout row wrap>
              <v-flex xs12>
                <filter-hour></filter-hour>
              </v-flex>
              <v-flex xs12>
                <filter-string></filter-string>
              </v-flex>
              <v-flex xs12>
                <filterZone></filterZone>
              </v-flex>
              <v-flex xs12>
                <filter-category></filter-category>
              </v-flex>
            </v-layout>
          </v-container>

        </v-card>

        <v-card flat>
          <drop @drop="handleDrop">

            <div class="zfc-panel-preevents pt-1" style="min-height:350px">
              <preEvent v-for="(preEvent,index) in getPreEventsFiltered"
                        :preEvent="preEvent"
                        :key="preEvent.id" :index="index">
              </preEvent>

            </div>
          </drop>
          <v-flex v-if="hasMorePreEvents" class="text-xs-center">
            <v-btn @click="incrementSize">Mostrar 10 mas</v-btn>
          </v-flex>

        </v-card>
      </v-tab-item>

      <v-tab-item>
        <v-card flat>
          <filter-calendars></filter-calendars>
        </v-card>
      </v-tab-item>

      <v-tab-item>
        <v-card flat>
          <service-search></service-search>
        </v-card>
      </v-tab-item>

    </v-tabs>

  </div>
</template>

<script>
  import {mapState, mapGetters, mapActions} from 'vuex';
  import preEvent from "./PreEvent.vue";
  import filterZone from './filters/filterZone.vue'
  import filterString from './filters/filterString.vue'
  import filterHour from './filters/filterHours.vue'
  import filterCalendars from "./filters/filterCalendars.vue"
  import serviceSearch from "./ServiceSearch.vue"
  import {Drop} from 'vue-drag-drop'
  import {EventService} from '../resource'
  import FilterCategory from "./filters/filterCategory";

  export default {
    name: 'panel',
    data() {
      return {
        showModal: false,
        active: null
      }
    },
    components: {
      FilterCategory,
      preEvent, filterZone,Drop, filterString, filterHour, filterCalendars, serviceSearch
    },
    computed: {
      ...mapState([
        'preEventSize',
        'eventSelected',
        'eventIndexSelected'
      ]),
      ...mapGetters([
        'hasMorePreEvents',
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
      ...mapActions([
        'preEventList'
      ]),
      incrementSize: function () {
        this.$store.commit('SET_PRE_EVENT_SIZE', this.preEventSize + 10);
      },
      handleDrop: function (data) {

        let event = data.event
        event.calendar = null
        EventService.updateEvent(event).then(
          () => {
            this.$store.commit('REMOVE_EVENT', this.getEventIndexById(data.event.id));
            this.$store.commit('ADD_PRE_EVENT', data.event);
          }
        ).catch(
          (error) => {
            console.log("Error On Update Event:",error);
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
