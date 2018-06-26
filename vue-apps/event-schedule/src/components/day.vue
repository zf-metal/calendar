<template>

    <ul class="nav navbar-nav">
        <li>
            <a @click="before">
                <i class="btn btn-xs material-icons" style="font-size:18px">navigate_before</i>
            </a>
        </li>
        <li>
            <form class="navbar-form navbar-left">
                <div class="form-group">
                    <input type="date" class="form-control" v-model="date" v-on:change="onChange">
                </div>
            </form>
        </li>
        <li>
            <a @click="next">
                <i class="btn btn-xs material-icons" style="font-size:18px">navigate_next</i>
            </a>
        </li>
    </ul>

</template>

<script>
  import {mapGetters, mapActions} from 'vuex';

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
      ...mapActions([
        'changeDate'
      ]),
      before: function () {
        var d = moment(this.date)
        d.subtract(1, 'day')
        this.date = d.tz('America/Argentina/Buenos_Aires').format("YYYY-MM-DD")
        this.changeDate(this.date)
      },
      next: function () {
        var d = moment(this.date)
        d.add(1, 'day')
        this.date = d.tz('America/Argentina/Buenos_Aires').format("YYYY-MM-DD")
        console.log(this.date)
        this.changeDate(this.date)
      },
      onChange: function () {
        var d = moment(this.date)
        this.changeDate(d)
      },
      getDate: function () {
        return this.date.tz('America/Argentina/Buenos_Aires').format("YYYY-MM-DD")
      }
    }
  }
</script>

