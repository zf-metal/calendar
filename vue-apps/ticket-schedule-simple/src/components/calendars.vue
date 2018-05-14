<template>
    <div>
        <div class="text-center">
        <day v-model="day"></day>
        </div>
        <calendar v-for="calendar in calendars" :calendar="calendar" :key="calendar.id">
        </calendar>
    </div>
</template>

<script>
  import axios from 'axios'
  import day from './day.vue'
  import calendar from './calendar.vue'

  const http = axios.create({
    baseURL: '/zfmapi/',
    timeout: 5000,
    headers: {
      accept: 'application/json'
    }
  });

  export default {
    name: 'calendars',
    components: {day,calendar},
    data() {
      return {
        calendars: [],
        day:  this.dateToYMD(new Date())
      }
    },
    created: function () {
      this.list();
    },
    methods: {
      list: function () {
        http.get('list/calendar').then((response) => {
          if (response.data.success) {
            this.calendars = response.data.data;
          }
        })
      },
      dateToYMD(date) {
        var d = date.getDate();
        var m = date.getMonth() + 1; //Month from 0 to 11
        var y = date.getFullYear();
        return '' + y + '-' + (m<=9 ? '0' + m : m) + '-' + (d <= 9 ? '0' + d : d);
      }

    },
    computed: {
      getDay: function(){

      }
    }
  }
</script>

<style scoped>
</style>
