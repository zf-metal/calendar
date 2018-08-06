<template>
    <div class="zfc-main-container">
        <navi></navi>
        <loading :isLoading="getLoading"></loading>
        <div class="clearfix"></div>
        <div class="col-lg-2" style="margin: 0; padding:0;">
            <panel v-on:forceUpdate="onForceUpdate"></panel>
        </div>

        <div class="col-lg-10 zfc-calendars-parent">
            <table class="table-bordered table-striped table-responsive zfc-calendar-table"  :style="getStyleHeaderFix" >
                <thead>
                <tr v-if="hasCalendars">
                    <th class="zfc-column-hours"></th>
                    <th class="zfc-column-calendar"
                        v-for="calendar in getVisibleCalendars"
                        :key="calendar.id">
                                <span>{{calendar.name}}
                                    <i @click="showMap(calendar.id,calendar.name)" class="material-icons cursorPointer pull-right" style="vertical-align: bottom">map</i></span>

                    </th>
                </tr>
                </thead>
            </table>
            <div class="zfc-calendars" ref="zfcCalendars" v-on:scroll="handleCalendarScroll">
            <table class="table-bordered table-striped table-responsive zfc-td">

                <tbody>

                <!--TODAY-->
                <tr v-if="hasCalendars" v-for="hour in getHours" v-bind:key="getDate + hour">
                    <td class="zfc-column-hours">{{hour}}</td>
                    <calendarTd
                            v-for="calendar in getVisibleCalendars"
                            :key='getDate + calendar.id + hour'
                            :calendarId="calendar.id" :name="calendar.name"
                            :date="getDate" :hour="hour"
                            :parentTop="top" :parentLeft="left" :rc="getRc" :isNextDay="false" :day="getDay"
                            :cellHeight="getCellHeight">
                    </calendarTd>
                </tr>

                <tr style="height: 3px;">
                    <th v-if="hasCalendars" class="zfc-column-hours" style="background-color: #0c0c0c ">
                    </th>

                    <td v-for="calendar in getVisibleCalendars" :key='calendar.id+"_nd"'
                        style="background-color: #0c0c0c ">
                    </td>
                </tr>

                <!--NEXTDAY-->
                <tr v-if="hasCalendars" v-for="hour in getNextHours" v-bind:key="getNextDate + hour">
                    <td class="zfc-column-hours">{{hour}}</td>
                    <calendarTd
                            v-for="calendar in getVisibleCalendars"
                            :key='getNextDate + calendar.id + hour'
                            :calendarId="calendar.id" :name="calendar.name"
                            :date="getNextDate" :hour="hour"
                            :parentTop="top" :parentLeft="left" :rc="getRc" :isNextDay="true" :day="getNextDay"
                            :cellHeight="getCellHeight">
                    </calendarTd>
                </tr>


                <tr>
                    <th v-if="hasCalendars" class="zfc-column-hours">FB</th>

                    <calendarTd v-for="calendar in getVisibleCalendars"
                                :key='calendar.id+"_fb"'
                                :calendarId="calendar.id" :name="calendar.name" :date="'fb'" :hour="'fb'"
                                :parentTop="top" :parentLeft="left">
                    </calendarTd>
                </tr>


                </tbody>
            </table>

            <event v-for="(event,index) in getEvents" v-if="isVisibleCalendar(event.calendar)" :key="index"
                   :index="index" :event="event"
                   :top="getCoordinate(event,'top')"
                   :left="getCoordinate(event,'left')"
                   v-on:editEvent="onEditEvent">
            </event>
            </div>
        </div>


        <modal :title="eventForm.id + '. '+ eventForm.title" :showModal="showModal" @close="showModal = false">
            <form-event :calendars="getCalendars" v-model="eventForm"
                        :index="eventIndex" v-on:remove="removeEvent"/>
        </modal>

        <modal :title="'Mapa: '+calendarName" :showModal="showModalMap" @close="showModalMap = false">
            <maps :calendarId="calendarId" :calendarName="calendarName"></maps>
        </modal>
    </div>
</template>

<script>
  import {mapGetters, mapActions} from 'vuex';
  import {calculateEnd} from './../utils/helpers'
  import {Drag, Drop} from 'vue-drag-drop';

  import modal from './helpers/modal.vue'
  import loading from './helpers/loading.vue'

  import navi from './navi.vue'
  import panel from './panel.vue'
  import calendarTd from './calendarTd.vue'
  import event from './event.vue'
  import preEvent from "./preEvent.vue";
  import formEvent from './forms/form-event.vue'
  import maps from './maps.vue'

  export default {
    name: 'calendars',
    components: {calendarTd, event, preEvent, Drag, Drop, modal, loading, formEvent, navi, panel, maps},
    data() {
      return {
        tds: {},
        eventForm: {},
        eventIndex: '',
        showModal: false,
        showModalMap: false,
        titleModal: '',
        calendarId: null,
        calendarName: null,
      }
    },
    created: function () {
      console.log("v1.3");
//      this.eventStateList();
//      this.zoneList();
//      this.eventTypeList();
//      this.calendarList();
      this.startList();


      this.preEventList();
    },
    mounted() {
      this.$nextTick(function () {
        window.addEventListener('scroll', this.handleWindowScroll);
        window.addEventListener('resize', this.handleCalendarPosition);
      });
      this.handleCalendarPosition();
    },
    watch: {
      getVisibleCalendars: function () {
        this.$nextTick(() => {
          this.$forceUpdate();
        });
      },
      getCellHeight: function () {
        this.$nextTick(() => {
          this.$forceUpdate();
        });
      },
    },
    computed: {
      ...mapGetters([
        'getCellHeight',
        'getLoading',
        'getCoordinate',
        'isVisibleCalendar',
        'hasCalendars',
        'getCalendars',
        'getVisibleCalendars',
        'getPreEventById',
        'getPreEvents',
        'getEvents',
        'getEventByKey',
        'getDate',
        'getNextDate',
        'getNextDay',
        'getDay',
        'getHours',
        'getNextHours',
        'getRc',
        'getCalendarScroll'
      ]),
      getStyleHeaderFix: function(){
        var left = this.left - this.getCalendarScroll.left;
        return 'left: '+ left+'px';
      }
    },
    methods: {
      ...mapActions([
        'startList',
        'zoneList',
        'eventStateList',
        'eventTypeList',
        'calendarList',
        'preEventList',
        'removePreEvent',
        'updateEvent',
        'pushEvent'
      ]),
      getEventDate: function (start) {
        return start.substr(0,10);
      },
      showMap: function (id, name) {
        this.calendarId = id;
        this.calendarName = name;
        this.showModalMap = true;
      },
      onForceUpdate() {
        console.log("forceUpdate");
        this.$forceUpdate();
      },
      removeEvent: function () {
        //TODO
        console.log('todo');
      },
      onEditEvent: function (index) {
        this.eventForm = this.getEventByKey(index)
        this.eventIndex = index
        this.titleModal = 'Evento: ' + this.eventForm.title
        this.showModal = true
      },
      handleCalendarPosition: function () {
        this.top = this.$refs.zfcCalendars.getBoundingClientRect().top;
        this.left = this.$refs.zfcCalendars.getBoundingClientRect().left;
        this.$store.commit('SET_CALENDAR_POSITION', {top: this.top, left: this.left});
      },
      handleCalendarScroll: function (e) {
        this.$store.commit('SET_CALENDAR_SCROLL', {top: e.srcElement.scrollTop, left: e.srcElement.scrollLeft});
      },
      handleWindowScroll: function (e) {
        this.$store.commit('SET_BODY_SCROLL', {
          top: e.srcElement.scrollTop || window.pageYOffset,
          left: e.srcElement.scrollLeft || window.pageXOffset
        });
      },
    }

  }
</script>

<style scoped>

    .zfc-main-container {
        height: 100vh;
        max-height: 100vh;
    }

    .zfc-calendars-parent{
        height: 88%;
        padding: 0;
    }

    .zfc-calendars {
        overflow-y: auto;
        overflow-x: auto;
        height: 95%;
        margin: 0;
        padding: 0;
        position: relative;
    }

    .zfc-column-hours {
        width: 50px !important;
        min-width: 50px;
        max-width: 50px;
    }

    .zfc-column-calendar {
        width: 260px !important;
        min-width: 260px !important;
        max-width: 260px !important;
        text-align: center;
    }

    .zfc-calendar-table{
        position: fixed;
        z-index: 11;
    }


    .zfc-calendar-table  th{
        background-color: #0e2c44 !important;
        color: #ffffcc;

    }

    table.zfc-td{
        margin-top: 28px;
    }

    table.zfc-td > tbody > tr > td, table.zfc-td > tbody > tr > th {
        font-size: 14px;
        padding: 0;
        margin: 0;
        text-align: center;
    }

    table.zfc-td > tbody > tr > td > div {
        height: 100%;
        background: #0d6aad;
    }

    .cursorPointer {
        cursor: pointer;
    }


</style>

<style>
    .lulu-theme {
        background: #ffffcc;
        background-color: #ffffcc;
        color: #0c0c0c;
        font-size: .9em;
    }

    .lulu-theme > .tippy-arrow {
        background: #ffffcc !important;
        background-color: #ffffcc !important;
        color: #ffffcc !important;
    }

    .tooltipTable {
        text-align: left;
    }

</style>
