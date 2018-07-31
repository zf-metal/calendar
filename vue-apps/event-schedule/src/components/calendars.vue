<template>
    <div>
        <navi></navi>

        <div class="clearfix"></div>
        <div class="col-lg-2" style="margin: 0; padding:0;">
            <panel v-on:forceUpdate="onForceUpdate"></panel>
        </div>

        <div class="col-lg-10" style="margin: 0; padding:0;">
            <loading :isLoading="getLoading"></loading>
            <div class="clearfix"></div>
            <div class="zfc-calendars" ref="zfcCalendars" v-on:scroll="handleCalendarScroll">
                <table class="table-bordered table-striped table-responsive  zfc-td">
                    <thead>
                    <tr v-if="hasCalendars">
                        <th class="zfc-column-hours"></th>
                        <th class="zfc-column-calendar"
                            v-for="calendar in getVisibleCalendars"
                            :key="calendar.id">
                            {{calendar.name}}
                        </th>
                    </tr>
                    </thead>

                    <tbody>
                    <tr v-if="hasCalendars" v-for="hour in getHours" v-bind:key="hour">
                        <td class="zfc-column-hours">{{hour}}</td>
                        <calendarTd
                                v-for="calendar in getVisibleCalendars"
                                :key='calendar.id + hour'
                                :calendarId="calendar.id" :name="calendar.name" :hour="hour"
                                :parentTop="top" :parentLeft="left" :rc="getRc"
                                :cellHeight="getCellHeight"
                                v-on:dropForNewEvent="onDropForNewEvent"
                                v-on:dropForChangeEvent="onDropForChangeEvent">
                        </calendarTd>
                    </tr>

                    <tr>
                        <th v-if="hasCalendars" class="zfc-column-hours">FB</th>
                        <calendarTd v-for="calendar in getVisibleCalendars"
                                    :key='calendar.id+"_fb"'
                                    :calendarId="calendar.id" :name="calendar.name" :hour="'fb'"
                                    :parentTop="top" :parentLeft="left">
                        </calendarTd>
                    </tr>
                    </tbody>
                </table>

                <event v-for="(event,index) in getEvents" v-if="isVisibleCalendar(event.calendar)" :key="index"
                       :index="index"
                       :id="event.id" :title="event.title" :description="event.description"
                       :duration="event.duration"
                       :date="event.getDate" :calendar="event.calendar" :hour="event.hour"
                       :ticketId="event.ticket"
                       :top="getCoordinate(event.calendar,event.hour,'top')"
                       :left="getCoordinate(event.calendar,event.hour,'left')"
                       :start="event.start" :end="event.end" :state="event.state" :type="event.type"
                       :lat="event.lat" :lng="event.lng"
                       :zone="event.zone" :client="event.client" :location="event.location"
                       :serviceDescription="event.serviceDescription"
                       v-on:editEvent="onEditEvent">
                </event>
            </div>
        </div>
        <modal :title="eventForm.title" :showModal="showModal" @close="showModal = false">
            <form-event :calendars="getCalendars" v-model="eventForm"
                        :index="eventIndex" v-on:remove="removeEvent"/>
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

  export default {
    name: 'calendars',
    components: {calendarTd, event, preEvent, Drag, Drop, modal, loading, formEvent, navi, panel},
    data() {
      return {
        tds: {},
        eventForm: {},
        eventIndex: '',
        showModal: false,
        titleModal: ''
      }
    },
    created: function () {
      this.eventStateList();
      this.zoneList();
      this.eventTypeList();
      this.calendarList();
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
        'getDay',
        'getHours',
        'getRc',
      ]),
    },
    methods: {
      ...mapActions([
        'zoneList',
        'eventStateList',
        'eventTypeList',
        'calendarList',
        'preEventList',
        'removePreEvent',
        'updateEvent',
        'pushEvent'
      ]),
      onForceUpdate() {
        console.log("forceUpdate");
        this.$forceUpdate();
      },
      removeEvent: function () {

      },
      onEditEvent: function (index) {
        this.eventForm = this.getEventByKey(index)
        this.eventIndex = index
        this.titleModal = 'Evento: ' + this.eventForm.title
        this.showModal = true
      },
      onDropForNewEvent: function (preEvent, index) {
        var event = preEvent;
        event.date = this.date
        event.start = this.getDate + " " + event.hour
        event.end = calculateEnd(event.start, event.duration)
        this.pushEvent(event);
        var i = this.getPreEventById(event.id);
        this.removePreEvent(i);
      },
      onDropForChangeEvent: function (calendar, eventKey, hour) {
        var event = this.getEventByKey(eventKey);
        event.hour = hour
        event.calendar = calendar
        event.start = this.getDate + " " + hour
        event.end = calculateEnd(event.start, event.duration)
        this.updateEvent({index: eventKey, event: event});
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

    .zfc-calendars {
        position: relative;
        overflow-y: auto;
        overflow-x: auto;
    }

    .zfc-column-hours {
        width: 50px;
    }

    .zfc-column-calendar {
        width: 260px;
        min-width: 260px;
        max-width: 260px;
        overflow: hidden;
        text-align: center;
    }

    table.zfc-td > tbody > tr > td, table.zfc-td > tbody > tr > th {
        font-size: 14px;
        /*height: 40px;*/
        padding: 0;
        margin: 0;
        text-align: center;
    }

    table.zfc-td > tbody > tr > td > div {
        height: 100%;
        background: #0d6aad;
    }
</style>

<style>
    .lulu-theme {
        background: #ffffcc;
        background-color: #ffffcc;
        color: #0c0c0c;
        font-size: .9em;
    }

    .lulu-theme > .tippy-arrow{
        background: #ffffcc !important;
        background-color: #ffffcc !important;
        color: #ffffcc !important;
    }

    .tooltipTable{
        text-align: left;
    }

</style>
