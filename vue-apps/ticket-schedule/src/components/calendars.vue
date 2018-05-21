<template>
    <div class="row">
        <div class="col-lg-2">
            <h3>Tickets</h3>
            <ticket v-if="tickets" v-for="ticket in tickets" :ticket="ticket" :key="ticket.id" :event="ticket.event">
            </ticket>
        </div>

        <div class="col-lg-10">
            <div class="text-center row">
                <div class="col-lg-2">
                    <loading :isLoading="loading"></loading>
                </div>
                <div class="col-lg-8">
                        <day v-model="getDate" v-on:changeDate="onChangeDate"></day>
                </div>
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
                                    :ref='getCalendarTdRef(calendar.id,hour)'
                                    :tid='getCalendarTdRef(calendar.id,hour)'
                                    :key='getCalendarTdRef(calendar.id,hour)'
                                    :calendarId="calendar.id" :name="calendar.name" :hour="hour"
                                    :parentTop="top" :parentLeft="left"
                                    v-on:dropForNewEvent="onDropForNewEvent"
                                    v-on:dropForChangeEvent="onDropForChangeEvent">
                        </calendarTd>

                    </tr>
                    </tbody>

                </table>

                <event v-if="events" v-for="(event,index) in events" :key="index" :index="index"
                       :id="event.id" :title="event.title" :description="event.description"
                       :duration="event.duration"
                       :date="event.getDate" :calendar="event.calendar" :hour="event.hour"
                       :ticketId="event.ticket"
                       :top="event.top" :left="event.left"
                       :start="event.start" :end="event.end"
                       v-on:editEvent="onEditEvent">

                </event>

            </div>
        </div>

        <modal :title="titleModal" :showModal="showModal" @close="showModal = false">
                <form-event :calendars="calendars"  v-model="eventForm"
                            :index="eventIndex" v-on:remove="removeEvent"
                v-on:eventUpdate="onEventUpdate"
                />
        </modal>

    </div>
</template>

<script>
  import axios from 'axios'
  import {Drag, Drop} from 'vue-drag-drop';

  import moment from 'moment'
  import momenttz from 'moment-timezone'
  import 'moment/locale/es';

  import modal from './helpers/modal.vue'
  import loading from './helpers/loading.vue'

  import day from './day.vue'
  import calendarTd from './calendarTd.vue'
  import event from './event.vue'
  import ticket from "./ticket.vue";

  import formEvent from './forms/form-event.vue'

  const http = axios.create({
    baseURL: '/zfmc/api/',
    timeout: 5000,
    headers: {
      accept: 'application/json'
    }
  });


  export default {
    name: 'calendars',
    components: {day, calendarTd, event, ticket, Drag, Drop, modal, loading, formEvent},
    data() {
      return {
        calendars: [],
        tickets: [],
        date: moment().locale('es'),
        events: [],
        tds: {},
        top: 0,
        left: 0,
        eventForm: {},
        eventIndex: '',
        loading: false,
        showModal: false,
        titleModal:''
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
        http.get('calendars').then((response) => {
          this.calendars = response.data;
          this.loadEvents();
        })
      },
      ticketList: function () {
        http.get('tickets').then((response) => {
          this.tickets = response.data;
        })
      },
      removeEvent: function () {

      },
      calculateEventDuraction: function (event) {
        if (event.start && event.end) {
          return moment(event.end).diff(moment(event.start), 'minutes');
        }
        return null;
      },
      getCalendarTdRef: function (calendarId, hour) {
        var hs = hour.split(":")
        var r = calendarId + "_" + hs[0] + "_" + hs[1]
        return r
      },
      getEventTid: function (event) {
        if (event.calendar && event.hour) {
          var hs = event.hour.split(":");
          var hour = "";
          if(hs[1] == "00" || hs[1] == "30") {
            hour = event.hour
          }else{
            if(hs[1]>30 ){
              hour = hs[0]+":30"
            }else{
              hour = hs[0]+":00"
            }
          }
          return this.getCalendarTdRef(event.calendar, hour)
        }
        return null;
      },
      onEditEvent: function (index) {
        this.eventForm = this.events[index]
        this.eventIndex = index
        this.titleModal = 'Evento: '+this.eventForm.title
        this.showModal = true
      },
      onChangeDate: function (d) {
        this.events = [];
        this.date = moment(d)
        this.loadEvents()
      },
      loadEvents: function () {
        this.loading = true;
        axios.get("/zfmc/api/events?start=" + this.getDate + "<>" + this.getNextDate
        ).then((response) => {
          var events = [];
          for (var i = 0; i < response.data.length; i++) {
            var event = response.data[i]
            //Hour
            event.hour = moment(event.start).tz('America/Argentina/Buenos_Aires').format("HH:mm");
            //Duration
            event.duration = this.calculateEventDuraction(event);
            //TOP-LEFT
            event.top = this.getCalendarTdTop(this.getEventTid(event));
            event.left = this.getCalendarTdLeft(this.getEventTid(event));
            events.push(event);
          }
          this.events = events;
          this.loading = false;
        })
      },
      createEvent: function (event) {
        this.loading = true;
        axios.post("/zfmc/api/events", event
        ).then((response) => {
          event.id = response.data.id
          this.setEventOnTicket(event.ticket, response.data.id)
          this.events.push(event);
          this.loading = false;
        }).catch((error) => {
          this.nowEvent.errors = error.response.data.errors
          this.loading = false;
        })
      },
      updateEvent: function (event) {
        this.loading = true;
        axios.put("/zfmc/api/events/" + event.id, event
        ).then((response) => {
          this.loading = false;
        }).catch((error) => {
          this.nowEvent.errors = error.response.data.errors
          this.loading = false;
        })
      },
      onDropForNewEvent: function (calendar, ticketId,ticketSubject,ticketLocation, hour, top, left) {
        if (this.getTicketById(ticketId)) {
          var event = {}
          event.id = ''
          event.calendar = calendar
          event.ticket = ticketId
          event.title = ticketSubject
          event.location = ticketLocation
          event.hour = hour
          event.top = top + this.getScrollX() + this.getBodyScrollTop()
          event.left = left + this.getScrollY() + this.getBodyScrollLeft()
          event.duration = 60
          event.date = this.date
          event.start = this.getDate + " " + hour
          var end = moment(this.getDate + " " + hour)
          event.end = end.add(event.duration, "minutes").tz('America/Argentina/Buenos_Aires').format("YYYY-MM-DD HH:mm")
          this.createEvent(event)
        }

      },
      onDropForChangeEvent: function (calendar, eventKey, hour, top, left) {
        this.events[eventKey].top = top + this.getScrollX() + this.getBodyScrollTop()
        this.events[eventKey].left = left + this.getScrollY() + this.getBodyScrollLeft()
        this.events[eventKey].hour = hour
        this.events[eventKey].calendar = calendar
        this.events[eventKey].start = this.getDate + " " + hour
        var end = moment(this.getDate + " " + hour)
        this.events[eventKey].end = end.add(this.events[eventKey].duration, "minutes").tz('America/Argentina/Buenos_Aires').format("YYYY-MM-DD HH:mm")
        this.updateEvent(this.events[eventKey])
      },
      onEventUpdate: function(event){
        if(this.getDate != moment(event.start).format("YYYY-MM-DD") ){
          this.events.splice(this.eventIndex,1)
        }else{
          event.hour = moment(event.start).tz('America/Argentina/Buenos_Aires').format("HH:mm");
          event.duration = this.calculateEventDuraction(event);
          event.top = this.getCalendarTdTop(this.getEventTid(event));
          event.left = this.getCalendarTdLeft(this.getEventTid(event));

        }
      },
      getTicketById: function (id) {
        for (var i = 0; i < this.tickets.length; i++) {
          if (this.tickets[i].id == id) {
            return this.tickets[i];
          }
        }
        return null;
      },
      setEventOnTicket: function (ticketId, eventId) {
        var ticket = this.getTicketById(ticketId)
        if (ticket) {
          ticket.event = eventId;
          this.updateTicket(ticket)
        }
        return null;
      },
      updateTicket: function (ticket) {
        this.loading = true;
        axios.put("/zfmc/api/tickets/" + ticket.id, ticket
        ).then((response) => {
          this.loading = false;
        }).catch((error) => {
          this.nowEvent.errors = error.response.data.errors
          this.loading = false;
        })
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
      getCalendarTdTop: function (refid) {
        return this.$refs[refid][0].getTop;
      },
      getCalendarTdLeft: function (refid) {
        return this.$refs[refid][0].getLeft;
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
    },
    computed: {

      getDate: function () {
        return this.date.tz('America/Argentina/Buenos_Aires').format("YYYY-MM-DD");
      },
      getNextDate: function () {
        var nextDate = moment(this.date.tz('America/Argentina/Buenos_Aires').format("YYYY-MM-DD"));
        return nextDate.add(1, 'day').tz('America/Argentina/Buenos_Aires').format("YYYY-MM-DD");
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
            if (this.calendars[index].schedules != undefined) {
              for (var i = 0; i < this.calendars[index].schedules.length; ++i) {
                if (this.calendars[index].schedules[i].day == this.getDay) {
                  if (this.calendars[index].schedules[i].start < rstart || rstart == null) {
                    rstart = this.calendars[index].schedules[i].start;
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
            if (this.calendars[index].schedules != undefined) {
              for (var i = 0; i < this.calendars[index].schedules.length; ++i) {
                if (this.calendars[index].schedules[i].day == this.getDay) {
                  if (this.calendars[index].schedules[i].end > rend || rend == null) {
                    rend = this.calendars[index].schedules[i].end;
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
          var t = moment(this.getStart, "HH:mm");
          var e = moment(this.getEnd, "HH:mm");
          while (flag) {
            hours.push(t.format("HH:mm"));
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
