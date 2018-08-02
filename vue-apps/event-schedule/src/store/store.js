import Vue from 'vue'
import Vuex from 'vuex'

import moment from 'moment'
import tz from 'moment-timezone'
import 'moment/locale/es';

import {HTTP} from './../utils/http-client'
import {calculateDistance, getRandomColor} from './../utils/helpers'

import {
  SET_DATE,
  ADD_CALENDAR, SET_CALENDARS, HIDE_CALENDAR, SHOW_CALENDAR,
  SET_PRE_EVENTS, SET_EVENTS, CLEAR_EVENTS, ADD_EVENT, UPDATE_EVENT, REMOVE_PRE_EVENTS,
  SET_COORDINATE, SET_BODY_SCROLL, SET_CALENDAR_SCROLL, SET_CALENDAR_POSITION,
  SET_EVENT_STATES, SET_EVENT_TYPES, SET_EVENT_SELECTED, SET_ZONES, HIDE_ZONE, SHOW_ZONE, SET_CELL_HEIGHT,
  UPDATE_RC, SET_FILTER_ZONE, SET_FILTER_STRING
} from './mutation-types'

Vue.use(Vuex)


/*
*
* STATE
*
*/

const state = {
  filterZone: null,
  filterString: null,
  cellHeight: 60,
  loading: 0,
  coordinates: {},
  calendarPosition: {top: 0, left: 0},
  bodyScroll: {top: 0, left: 0},
  calendarScroll: {top: 0, left: 0},
  date: moment().tz('America/Argentina/Buenos_Aires').locale('es'),
  calendars: [],
  vcalendars: [],
  rc: 1,
  preEvents: [],
  preEventsByZone: {},
  events: [],
  eventStates: [],
  zones: {},
  hiddenZones: [],
  eventTypes: [],
  eventSelected: null,
  weekDays: {1: "Lunes", 2: "Martes", 3: "Miercoles", 4: "Jueves", 5: "Viernes", 6: "Sabado", 7: "Domingo"},
  months: {
    1: "Enero",
    2: "Febrero",
    3: "Marzo",
    4: "Abril",
    5: "Mayo",
    6: "Junio",
    7: "Julio",
    8: "Agosto",
    9: "Septiembre",
    10: "Octubre",
    11: "Noviembre",
    12: "Diciembre"
  }
};

/*
*
* GETTERS
*
*/

const getters = {
  getFilterZone: (state) => {
    return state.filterZone;
  },
  getFilterString: (state) => {
    return state.filterString;
  },
  getCellHeight: (state) => {
    return state.cellHeight;
  },
  getDistanceFromEventSelected: (state) => (dlat, dlng) => {
    if (state.eventSelected != undefined) {

      var lat = state.events[state.eventSelected].lat;
      var lng = state.events[state.eventSelected].lng;
      var distance = calculateDistance(lat, lng, dlat, dlng);
      return parseFloat(Math.round(distance * 100) / 100).toFixed(2);

    }
    return '-';
  },
  getIndexEventSelected: state => {
    return state.eventSelected
  },
  getServiceSelected: state => {
    if (state.eventSelected != undefined && state.eventSelected != null) {
      if (state.events[state.eventSelected] != undefined && state.events[state.eventSelected].serviceDescription != undefined) {
        return state.events[state.eventSelected].serviceDescription;
      }
    }
    return {};
  },
  getRc: state => {
    return state.rc
  },
  getCoordinates: state => {
    return state.coordinates;
  },
  getCoordinate: (state) => (calendar, hour, type) => {
    if (state.coordinates[calendar][hour] == undefined) {
      return state.coordinates[calendar]['fb'][type];
    }
    return state.coordinates[calendar][hour][type];
  },
  getLoading: state => {
    return state.loading;
  },
  isVisibleCalendar: (state) => (id) => {
    var calendar = state.calendars.find(calendar => calendar.id === id);
    if (calendar.hidden == true) {
      return false
    }
    return true
  },
  getCalendarSchedule: (state, getters) => (id) => {
    var calendar = state.calendars.find(calendar => calendar.id === id);
    return calendar.schedules.find(schedule => schedule.day === getters.getDay);
  },
  getCalendars: state => {
    return state.calendars;
  },
  getVisibleCalendars: state => {
    return state.calendars.filter(calendar => calendar.hidden != true);
  },
  hasCalendars: (state) => {
    if (state.calendars != undefined && state.calendars.length > 0) {
      return true;
    }
    return false;
  },
  getPreEventById: (state) => (id) => {
    return state.preEvents.map(function (x) {
      return x.id;
    }).indexOf(id);
  },
  getPreEvents: state => {
    return state.preEvents;
  },
  getPreEventsFiltered: state => {
    if ((state.filterZone != null && state.filterZone != "") || (state.filterString != null && state.filterString != "")) {
      return state.preEvents.filter(function (e) {
        if (
          (e.zone != undefined && e.zone.id != undefined && (state.filterZone == null || state.filterZone == "" || e.zone.id == state.filterZone)) &&
          (state.filterString == "" || state.filterString == null || e.client.toLowerCase().indexOf(state.filterString) > -1)
        ) {
          return true;
        }
        return false;
      });
    }
    return state.preEvents;
  },
  getPreEventsByZone: (state) => (id) => {
    //  return state.preEvents.filter(preEvent => preEvent.zone.id === id);
    return state.preEvents.filter(function (el) {
        if (el.zone != undefined && el.zone.id != undefined && el.zone.id == id) {
          return true;
        }
        return false;
      }
    );

  },
  getZoneBgColor: (state) => (id) => {
    if (state.zones[id] != undefined && state.zones[id].bgColor != undefined) {
      return state.zones[id].bgColor;
    }
    return "";
  },
  getZones: state => {
    return state.zones;
  },
  getEvents: state => {
    return state.events;
  },
  getEventStates: state => {
    return state.eventStates;
  },
  getEventStateById: (state) => (id) => {
    return state.eventStates.find(eventState => eventState.id === id)
  },
  getEventStateBgColor: (state, getters) => (stateId) => {
    var state = getters.getEventStateById(stateId);
    if (state != undefined && state.bgColor != undefined && state.bgColor != "") {
      return state.bgColor;
    }
    return '#1c5c87';
  },
  getEventTypeById: (state) => (id) => {
    return state.eventTypes.find(eventType => eventType.id === id)
  },
  getEventTypeIcon: (state, getters) => (typeId) => {
    var type = getters.getEventTypeById(typeId);
    if (type != undefined && type.icon != undefined && type.type != "") {
      return type.icon;
    }
    return 'all_out';
  },
  getEventTypes: state => {
    return state.eventTypes;
  },
  getEventByKey: (state) => (key) => {
    return state.events[key];
  },
  getDate: state => {
    return state.date.format("YYYY-MM-DD");
  },
  getNextDate: (state, getters) => {
    var nextDate = tz(getters.getDate);
    return nextDate.add(1, 'day').format("YYYY-MM-DD");
  },
  getDay: state => {
    return state.date.isoWeekday();
  },
  getMonthName: state => {
    return state.date.format('MMMM').replace(/\w/, c => c.toUpperCase());
  },
  getDayName: state => {
    return state.date.format('dddd').replace(/\w/, c => c.toUpperCase());
  },
  getNumberOfDayInMonth: state => {
    var cloneDate = state.date.clone();
    var count = 0;
    do {
      count++;
      cloneDate.subtract(1, 'week');
    } while (state.date.month() == cloneDate.month())
    return count;
  },
  getNumberOfDayInMonthOrdinal: (state, getters) => {
    switch (getters.getNumberOfDayInMonth) {
      case 1:
        return "1er";
      case 2:
        return "2do";
      case 3:
        return "3er";
      case 4:
        return "4to";
      case 5:
        return "5to";
    }
    return "";
  },
  getStart: (state, getters) => {
    var rstart = null;
    if (getters.hasCalendars) {
      for (var index = 0; index < state.calendars.length; ++index) {
        if (state.calendars[index].schedules != undefined) {
          for (var i = 0; i < state.calendars[index].schedules.length; ++i) {
            if (state.calendars[index].schedules[i].day == getters.getDay) {
              if (state.calendars[index].schedules[i].start < rstart || rstart == null) {
                rstart = state.calendars[index].schedules[i].start;
              }
            }
          }
        }
      }
    }

    if (rstart == null) {
      rstart = "00:00"
    }
    return rstart;
  },
  getEnd: (state, getters) => {
    var rend = null;
    if (getters.hasCalendars) {
      for (var index = 0; index < state.calendars.length; ++index) {
        if (state.calendars[index].schedules != undefined) {
          for (var i = 0; i < state.calendars[index].schedules.length; ++i) {
            if (state.calendars[index].schedules[i].day == getters.getDay) {
              if (state.calendars[index].schedules[i].end > rend || rend == null) {
                rend = state.calendars[index].schedules[i].end;
              }
            }
          }
        }
      }
    }
    if (rend == null) {
      rend = "23:00"
    }
    return rend;
  },
  getHours: (state, getters) => {
    var hours = [];
    if (getters.hasCalendars) {
      var flag = true;
      var t = moment(getters.getStart, "HH:mm");
      var e = moment(getters.getEnd, "HH:mm");
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

};

/*
*
* ACTIONS
*
*/

const actions = {
  hideZone({commit}, index) {
    commit('HIDE_ZONE', index);
  },
  showZone({commit}, index) {
    commit('SHOW_ZONE', index);
  },
  hideCalendar({commit}, index) {
    commit('HIDE_CALENDAR', index);
  },
  showCalendar({commit}, index) {
    commit('SHOW_CALENDAR', index);
  },
  changeDate({commit, dispatch}, date) {
    console.log(date)
    var newDate = moment(date)
    if (newDate.isValid()) {
      commit('SET_DATE', newDate);
      commit('CLEAR_EVENTS', newDate);
      dispatch('eventList');
    }
  },
  eventStateList({commit}) {
    state.loading = state.loading + 1;
    HTTP.get('event-states').then((response) => {
      commit("SET_EVENT_STATES", response.data);
      state.loading = state.loading - 1;
    })
  },
  getRandomColor: function () {
    return '#' + (Math.random() * 0xFFFFFF << 0).toString(16);
  },
  zoneList({commit, dispatch}) {
    state.loading = state.loading + 1;
    HTTP.get('zones').then((response) => {
      var zones = {};
      for (var i = 0; i < response.data.length; i++) {
        var zone = response.data[i];
        if (zone.bgColor == undefined) {
          zone.bgColor = getRandomColor();
        }
        zones[zone.id] = zone;
      }
      commit("SET_ZONES", zones);
      state.loading = state.loading - 1;
    })
  },
  eventTypeList({commit}) {
    state.loading = state.loading + 1;
    HTTP.get('event-types').then((response) => {
      commit("SET_EVENT_TYPES", response.data);
      state.loading = state.loading - 1;
    })
  },
  calendarList({state, commit, dispatch}) {
    state.loading = state.loading + 1;
    HTTP.get('calendars').then((response) => {
      commit(SET_CALENDARS, response.data);
      state.loading = state.loading - 1;
      dispatch('eventList');
    })
  },
  preEventList({commit, getters, state}) {
    state.loading = state.loading + 1;
    HTTP.get('events?calendar=isNull&dateFrom=<=' + getters.getDate + '&orderby=zone').then((response) => {
      // var events = {};
      // for (var i = 0; i < response.data.length; i++) {
      //   var event = response.data[i];
      //   events[event.id] = event;
      // }
      commit("SET_PRE_EVENTS", response.data);
      state.loading = state.loading - 1;
    });
  },
  eventList({state, getters, commit}) {
    state.loading = state.loading + 1;
    HTTP.get("events?calendar=isNotNull&start=" + getters.getDate + "<>" + getters.getNextDate
    ).then((response) => {
      var events = [];
      for (var i = 0; i < response.data.length; i++) {
        var event = response.data[i];
        if (event.calendar != null) {
          event.hour = moment(event.start).tz('America/Argentina/Buenos_Aires').format("HH:mm");
          events.push(event);
        }
      }
      commit("SET_EVENTS", events);
      state.loading = state.loading - 1;
    })
  },
  pushEvent({state, commit}, event) {
    event.hour = moment(event.start).tz('America/Argentina/Buenos_Aires').format("HH:mm");
    state.loading = state.loading + 1;

    HTTP.put("events/" + event.id, event
    ).then((response) => {
      state.loading = state.loading - 1;
      commit('ADD_EVENT', event);
    }).catch((error) => {
      state.loading = state.loading - 1;
    })
  },
  updateEvent({state, commit}, {index, event}) {
    state.loading = state.loading + 1;
    HTTP.put("events/" + event.id, event
    ).then((response) => {
      state.loading = state.loading - 1;
      commit(UPDATE_EVENT, {index: index, event: event})
    }).catch((error) => {
      state.loading = state.loading - 1;
    })
  },
  removePreEvent({commit}, index) {
    commit("REMOVE_PRE_EVENTS", index);
  }

};

const mutations = {
  [SET_DATE](state, newDate) {
    state.date = newDate;
  },
  [ADD_CALENDAR](state, calendar) {
    state.calendars.push(calendar);
  },
  [SHOW_CALENDAR](state, index) {
    Vue.set(state.calendars[index], 'hidden', false);
    state.rc++;
  },
  [HIDE_CALENDAR](state, index) {
    Vue.set(state.calendars[index], 'hidden', true)
    state.rc++;
  },
  [SHOW_ZONE](state, index) {
    Vue.set(state.zones[index], 'hidden', false);
  },
  [HIDE_ZONE](state, index) {
    Vue.set(state.zones[index], 'hidden', true)
  },
  [SET_ZONES](state, zones) {
    state.zones = zones;
  },
  [SET_EVENT_STATES](state, eventStates) {
    state.eventStates = eventStates;
  },
  [SET_EVENT_TYPES](state, eventTypes) {
    state.eventTypes = eventTypes;
  },
  [SET_CALENDARS](state, calendars) {
    state.calendars = calendars;
  },
  [SET_PRE_EVENTS](state, preEvents) {
    state.preEvents = preEvents;
  },
  [SET_EVENT_SELECTED](state, index) {
    state.eventSelected = index;
  },
  [SET_EVENTS](state, events) {
    state.events = events;
  },
  [CLEAR_EVENTS](state) {
    state.events = []
  },
  [REMOVE_PRE_EVENTS](state, index) {
    state.preEvents.splice(index, 1);
  },
  [ADD_EVENT](state, event) {
    state.events.push(event);
  },
  [UPDATE_EVENT](state, {index, event}) {
    state.events[index] = event;
  },
  [SET_COORDINATE](state, {calendar, hour, type, value}) {
    if (state.coordinates[calendar] == undefined) {
      state.coordinates[calendar] = {};
    }
    if (state.coordinates[calendar][hour] == undefined) {
      state.coordinates[calendar][hour] = {};
    }
    Vue.set(state.coordinates[calendar][hour], type, value);
    //  console.log("SET_COOR", calendar, hour, type, state.coordinates[calendar][hour][type])
  },
  [SET_CALENDAR_POSITION](state, {top, left}) {
    state.calendarPosition.top = top;
    state.calendarPosition.left = left;
  },
  [SET_BODY_SCROLL](state, {top, left}) {
    state.bodyScroll.top = top;
    state.bodyScroll.left = left;
  },
  [SET_CALENDAR_SCROLL](state, {top, left}) {
    state.calendarScroll.top = top;
    state.calendarScroll.left = left;
  },
  [SET_CELL_HEIGHT](state, cellHeight) {
    state.cellHeight = cellHeight;
    state.rc++;
  },
  [UPDATE_RC](state) {
    state.rc++;
  },
  [SET_FILTER_ZONE](state, filterZoneId) {
    state.filterZone = filterZoneId;
  },
  [SET_FILTER_STRING](state, filterString) {
    state.filterString = filterString;
  }
};


const store = new Vuex.Store({
  state,
  getters,
  actions,
  mutations
});


export default store;