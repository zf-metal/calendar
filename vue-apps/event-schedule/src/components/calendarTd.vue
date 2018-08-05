<template>
    <td class="zfc-column-calendar" :class="getClassDependingHour" :id="tid" style="height: 100px" :style="getCalendarTdStyle">
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
    props: ['calendarId', 'tid', 'name', 'date','hour', 'parentTop', 'parentLeft', 'rc', 'cellHeight'],
    components: {Drag, Drop},
    data() {
      return {
        top: 0,
        left: 0,
      }
    },
    mounted: function () {
      this.calculateTop();
      this.calculateLeft();
    },
    methods: {
      ...mapActions([
        'removePreEvent',
        'updateEvent',
        'pushEvent'
      ]),
      handleDrop: function (data) {

        var event = data.event;
        event.calendar = this.calendarId;
        event.start = this.date + " " + this.hour;
        event.end = calculateEnd(event.start, event.duration);
        event.hour = this.hour;

        if (data.op != undefined && data.op == 'push') {
          this.pushEvent(event);
          this.removePreEvent(data.index);
        }
        if (data.op != undefined && data.op == 'update') {
          this.updateEvent({index: data.index, event: event});
        }
      },
      calculateTop() {
        this.top = this.$el.getBoundingClientRect().top - this.parentTop;
        this.$store.commit('SET_COORDINATE', {
          calendar: this.calendarId,
          date: this.date,
          hour: this.hour,
          type: 'top',
          value: this.top
        });
      },
      calculateLeft() {
        this.left = this.$el.getBoundingClientRect().left - this.parentLeft + 10;
        this.$store.commit('SET_COORDINATE', {
          calendar: this.calendarId,
          date: this.date,
          hour: this.hour,
          type: 'left',
          value: this.left
        });
      }
    },
    watch: {
      rc: function () {
        this.calculateTop()
        this.calculateLeft()
      },
      parentTop: function () {
        this.calculateTop()
      },
      parentLeft: function () {
        this.calculateLeft()
      }
    },
    computed: {
      ...mapGetters([
        'getCalendarSchedule',
        'getEventByKey'
      ]),
      getCalendarTdStyle: function () {
        return "height:" + this.cellHeight + "px";
      },
      getClassDependingHour: function () {
        var schedule = this.getCalendarSchedule(this.calendarId);

        if (
          (this.hour >= schedule.start && this.hour < schedule.end) ||
          (this.hour >= schedule.start2 && this.hour < schedule.end2)
        ) {
          return 'zfc-hour-active';
        }
        return 'zfc-hour-inactive';
      }
    }
  }
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
    .zfc-dropcell {
        height: 100%;
    }

    .zfc-hour-active{
        background-color: #F0F8FF;
    }

    .zfc-hour-inactive{
        background-color: #CFC9C8;
    }
</style>
