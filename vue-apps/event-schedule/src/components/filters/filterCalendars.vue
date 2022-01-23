<template>
  <div>

    <h4>Filtro por Calendarios</h4>
    <v-btn class="btn btn-sm" @click="all">Todos</v-btn>
    <v-btn class="btn btn-sm" @click="neither">Ninguno</v-btn>
    <filterGroupCalendar></filterGroupCalendar>
    <template v-if="hasCalendars">
      <check-calendar

          v-for="(calendar,index) in getCalendars" :key="index"
          :index="index" :name="calendar.name" :id="calendar.id"
          :hidden="getCalendars[index].hidden"
      ></check-calendar>
    </template>
  </div>
</template>

<script>
import {mapGetters} from 'vuex';
import checkCalendar from "../checkCalendar.vue"
import filterGroupCalendar from "./filterGroupCalendar.vue"

export default {
  name: 'filterCalendars',
  props: [],
  components: {checkCalendar, filterGroupCalendar},
  data() {
    return {
      zoneId: ""
    }
  },
  created: function () {
  },
  methods: {
    all: function () {
      this.$store.commit('SET_CALENDAR_GROUP_SELECTED', "");
      for (var index = 0; index < this.getCalendars.length; ++index) {
        this.$store.commit('SHOW_CALENDAR', index);
      }
    },
    neither: function () {
      this.$store.commit('SET_CALENDAR_GROUP_SELECTED', "");
      for (var index = 0; index < this.getCalendars.length; ++index) {
        this.$store.commit('HIDE_CALENDAR', index);
      }
    }
  },
  computed: {
    ...mapGetters([
      'getCalendars',
      'hasCalendars'
    ]),
  },
}
</script>

<style scoped>

</style>
