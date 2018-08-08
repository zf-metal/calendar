<template>
    <div>
        <h4>Filtro por Calendarios</h4>
        <button class="btn btn-sm" @click="all">Todos</button>
        <button class="btn btn-sm" @click="neither">Ninguno</button>
        <check-calendar
                v-if="hasCalendars"
                v-for="(calendar,index) in getCalendars" :key="index"
                :index="index" :name="calendar.name" :id="calendar.id"
                :hidden="getCalendars[index].hidden"
        ></check-calendar>

    </div>
</template>

<script>
  import {mapGetters, mapActions} from 'vuex';
  import checkCalendar from "./checkCalendar.vue"

  export default {
    name: 'filterCalendars',
    props: [],
    components: {checkCalendar},
    data() {
      return {
        zoneId: ""
      }
    },
    created: function () {
    },
    methods: {
      ...mapActions([
        'showCalendar',
        'hideCalendar',
      ]),
      all: function () {
        for (var index = 0; index < this.getCalendars.length; ++index) {
          this.showCalendar(index);
        }
      },
      neither: function () {
        for (var index = 0; index < this.getCalendars.length; ++index) {
          this.hideCalendar(index);
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
