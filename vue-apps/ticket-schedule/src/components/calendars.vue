<template>
    <div class="row">
        <div class="col-lg-2">
            <h3>Tickets</h3>
            <ticket v-if="tickets" v-for="ticket in tickets" :ticket="ticket" :key="ticket.id" :event="ticket.event">
            </ticket>
        </div>

        <div class="col-lg-10">
            <div class="text-center">
                <day v-model="getDate"></day>
            </div>
            <div class="clearfix"></div>
            <div class="zfc-calendars" ref="zfcCalendars">
                <table class="table-bordered table-striped table-responsive  zfc-td">
                    <thead>
                    <tr>
                        <th class="zfc-column-hours"></th>
                        <th class="zfc-column-calendar" v-if="hasCalendars" v-for="calendar in calendars"
                            :key="calendar.id">
                            {{calendar.name}}
                        </th>

                    </tr>
                    </thead>

                    <tbody>
                    <tr v-if="hasCalendars" v-for="hour in getHours" v-bind:key="hour">

                        <td class="zfc-column-hours">{{hour}}</td>

                        <calendarTd v-if="hasCalendars"
                                    v-for="calendar in calendars"
                                    :id="calendar.id" :name="calendar.name" :hour="hour"
                                    :parentTop="top" :parentLeft="left"
                                    :key='calendar.id + "-" + hour'
                                    v-on:dropForNewEvent="onDropForNewEvent"
                                    v-on:dropForChangeEvent="onDropForChangeEvent">
                        </calendarTd>

                    </tr>
                    </tbody>

                </table>

                <event v-if="events" v-for="(event,index) in events" :key="index"
                       :date="date" :calendar="event.calendar" :hour="event.hour" :ticketId="event.ticketId"
                       :top="event.top" :left="event.left">

                </event>

            </div>
        </div>
    </div>
</template>

<script>
  import axios from 'axios'
  import {Drag, Drop} from 'vue-drag-drop';

  import moment from 'moment'
  import 'moment/locale/es';


  import day from './day.vue'
  import calendarTd from './calendarTd.vue'
  import event from './event.vue'
  import ticket from "./ticket.vue";

  const http = axios.create({
    baseURL: '/calendar/api/',
    timeout: 5000,
    headers: {
      accept: 'application/json'
    }
  });


  const httpTickets = axios.create({
    baseURL: '/zfmapi/',
    timeout: 5000,
    headers: {
      accept: 'application/json'
    }
  });



  export default {
    name: 'calendars',
    components: {day, calendarTd, event, ticket, Drag, Drop},
    data() {
      return {
        calendars: [],
        tickets: [],
        date: moment().locale('es'),
        events: [],
        top: 0,
        left: 0
      }
    },
    created: function () {
      this.calendarList();
      this.ticketList();
    },
    mounted() {
      this.$nextTick(function () {
        window.addEventListener('resize', this.onResize);
      });
      this.getTop();
      this.getLeft();
    },
    methods: {
      calendarList: function () {
        http.get('list').then((response) => {
          if (response.data.success) {
            this.calendars = response.data.data;

          }
        })
      },
      ticketList: function () {
        httpTickets.get('list/ticket').then((response) => {
          this.tickets = response.data.data;
        })
      },
      onResize: function () {
        this.getTop();
        this.getLeft();
      },
      getTop: function () {
        this.top = this.$refs.zfcCalendars.getBoundingClientRect().top;
      },
      getLeft: function () {
        this.left = this.$refs.zfcCalendars.getBoundingClientRect().left;
      },
      onDropForNewEvent: function (calendar, ticketId, hour, top, left) {
        this.events.push({
          calendar: calendar,
          ticketId: ticketId,
          hour: hour,
          top: top + this.getScrollX() + this.getBodyScrollTop(),
          left: left + this.getScrollY() + this.getBodyScrollLeft()
        });
        this.getTicketById(ticketId).event = 1;
      },
      onDropForChangeEvent: function (calendar, eventKey, hour, top, left) {
        this.events[eventKey].top = top + this.getScrollX() + this.getBodyScrollTop();
        this.events[eventKey].left = left + this.getScrollY() + this.getBodyScrollLeft();
        this.events[eventKey].hour = hour;
        this.events[eventKey].calendar = calendar;
      },
      getTicketById: function(id){
        for(var i=0; i< this.tickets.length;i++){
          if(this.tickets[i].id == id){
            return this.tickets[i];
          }
        }
        return null;
      },
      getScrollX: function () {
        return this.$refs.zfcCalendars.scrollTop;
      },
      getScrollY: function () {
        return this.$refs.zfcCalendars.scrollLeft;
      },
      getBodyScrollTop() {
        return window.pageYOffset || document.documentElement.scrollTop;
      },
      getBodyScrollLeft() {
        return window.pageXOffset || document.documentElement.scrollLeft;
      },
    },
    computed: {

      getDate: function () {
        return this.date.format("YYYY-MM-DD");
      },
      getDay: function () {
        return this.date.day() + 1;
      },
      hasCalendars: function () {
        if (this.calendars != undefined && this.calendars.length > 0) {
          return true;
        }
        return false;
      },
      getStart: function () {
        var rstart = null;
        if (this.hasCalendars) {
          for (var index = 0; index < this.calendars.length; ++index) {
            if (this.calendars[index].schedules.collection != undefined) {
              for (var i = 0; i < this.calendars[index].schedules.collection.length; ++i) {
                if (this.calendars[index].schedules.collection[i].day == this.getDay) {
                  if (this.calendars[index].schedules.collection[i].start < rstart || rstart == null) {
                    rstart = this.calendars[index].schedules.collection[i].start;
                  }

                }
              }
            }
          }
        }
        return rstart;
      },
      getEnd: function () {
        var rend = null;
        if (this.hasCalendars) {
          for (var index = 0; index < this.calendars.length; ++index) {
            if (this.calendars[index].schedules.collection != undefined) {
              for (var i = 0; i < this.calendars[index].schedules.collection.length; ++i) {
                if (this.calendars[index].schedules.collection[i].day == this.getDay) {
                  if (this.calendars[index].schedules.collection[i].end > rend || rend == null) {
                    rend = this.calendars[index].schedules.collection[i].end;
                  }
                  4
                }
              }
            }
          }
        }
        return rend;
      },
      getHours: function () {
        var hours = [];
        if (this.hasCalendars) {
          var flag = true;
          var t = moment(this.getStart, "hh:mm");
          var e = moment(this.getEnd, "hh:mm");
          while (flag) {
            hours.push(t.format("hh:mm"));
            t.add(30, "minutes");
            if (t >= e) {
              flag = false;
            }
          }
        }
        return hours;
      }

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
        width: 180px;
        min-width: 180px;
        max-width: 180px;
        overflow: hidden;
    }

    table.zfc-td > tbody > tr > td, table.zfc-td > tbody > tr > th {
        font-size: 14px;
        height: 25px;
        padding: 0;
        margin: 0;
        text-align: center;
    }

    table.zfc-td > tbody > tr > td > div {
        height: 100%;
        background: #0d6aad;
    }
</style>
