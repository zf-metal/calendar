<template>
    <div>
        <a class="btn btn-xs material-icons" @click="before"> <i class="material-icons">navigate_before</i></a>
        <input type="date" class="" v-model="date" v-on:change="onChange">
        <a class="btn btn-xs material-icons" @click="next"><i class="material-icons">navigate_next</i></a>
    </div>
</template>

<script>
  import moment from 'moment'
  import momenttz from 'moment-timezone'
  import 'moment/locale/es';

  export default {
    name: 'day',
    props: ['value'],
    data() {
      return {
        date: ''
      }
    },
    created: function () {
      this.date = this.value;
    },
    methods: {
      before: function () {
        var d = moment(this.date)
        d.subtract(1, 'day')
        this.date = d.tz('America/Argentina/Buenos_Aires').format("YYYY-MM-DD")
        this.emitChange(d)
      },
      next: function () {
        var d = moment(this.date)
        d.add(1, 'day')
        this.date = d.tz('America/Argentina/Buenos_Aires').format("YYYY-MM-DD")
        this.emitChange(d)
      },
      onChange: function () {
        var d = moment(this.date)
        this.emitChange(d)
      },
      emitChange: function (d) {
        this.$emit("changeDate", d)
      },
      getDate: function () {
        return this.date.tz('America/Argentina/Buenos_Aires').format("YYYY-MM-DD")
      }
    }
  }
</script>

