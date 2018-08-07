<template>
    <td class="zfc-column-calendar" :class="getClassDependingHour" :id="ki" :style="getCalendarTdStyle" >
        <drop @drop="handleDrop" class="zfc-dropcell">
        </drop>
    </td>
</template>

<script>
  import {mapGetters, mapActions} from 'vuex';
  import {Drag, Drop} from 'vue-drag-drop';
  import {calculateEnd} from './../utils/helpers'

  export default {
    name: 'calnedarTd',
    props: ['calendarId', 'ki', 'name', 'date', 'hour', 'parentTop', 'parentLeft', 'rc', 'cellHeight', 'isNextDay', 'day'],
    components: {Drag, Drop},
    data() {
      return {
        top: 0,
        left: 0,
        upHere: false,
      }
    },
    mounted: function () {
      this.calculateTop();
      this.calculateLeft();
      this.$nextTick(() => {
        this.calculateTop();
        this.calculateLeft();
      });
    },
    methods: {
      ...mapActions([
        'removePreEvent',
        'updateEvent',
        'pushEvent',
      ]),
      handleDrop: function (data) {

        var event = data.event;
        event.calendar = this.calendarId;
        event.start = this.date + " " + this.hour;
        event.end = calculateEnd(event.start, event.duration);
        event.hour = this.hour;

        if (data.op != undefined && data.op == 'push') {
          this.pushEvent(event);
          this.removePreEvent(this.getPreEventById(event.id));
        }
        if (data.op != undefined && data.op == 'update') {
          this.updateEvent({index: data.index, event: event});
        }
      },
      calculateTop() {
        this.top = this.$el.getBoundingClientRect().top - this.parentTop;
    //    this.top = this.$el.getBoundingClientRect().top;
        this.$store.commit('SET_COORDINATE', {
          calendar: this.calendarId,
          date: this.date,
          hour: this.hour,
          type: 'top',
          value: this.top
        });
        return this.top;
      },
      calculateLeft() {
        this.left = this.$el.getBoundingClientRect().left - this.parentLeft + 5;
     //   this.left = this.$el.getBoundingClientRect().left + 5;
        this.$store.commit('SET_COORDINATE', {
          calendar: this.calendarId,
          date: this.date,
          hour: this.hour,
          type: 'left',
          value: this.left
        });

        return this.left;
      },

    },
    computed: {
      ...mapGetters([
        'getRc',
        'getCalendarSchedule',
        'getEventByKey',
        'getPreEventById'
      ]),
      getCalendarTdStyle: function () {
        return "height:" + this.cellHeight + "px";
      },
      getClassDependingHour: function () {
        var schedule = this.getCalendarSchedule(this.calendarId, this.day);

        if (!schedule || (!schedule.start && !schedule.end)) {
          return this.isNextDay == true ? 'zfc-hour-inactive-nd' : 'zfc-hour-inactive';
        }

        if ((this.hour >= schedule.start && this.hour < schedule.end) || (this.hour >= schedule.start2 && this.hour < schedule.end2)) {
          return this.isNextDay == true ? 'zfc-hour-active-nd' : 'zfc-hour-active';
        }
        return this.isNextDay == true ? 'zfc-hour-inactive-nd' : 'zfc-hour-inactive';

      }
    }
  }
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
    .zfc-dropcell {
        height: 100%;
    }

    .zfc-hour-active {
        background-color: #fcfaee;
    }

    .zfc-hour-inactive {
        background-color: #a5a0a0;
    }

    .zfc-hour-active-nd {
        background-color: #faf5dd;
    }

    .zfc-hour-inactive-nd {
        background-color: #7c7878;
    }
</style>
