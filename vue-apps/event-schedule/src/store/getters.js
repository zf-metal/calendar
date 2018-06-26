import moment from 'moment'
import tz from 'moment-timezone'
import 'moment/locale/es';

import {calculateDistance} from './../utils/helpers'

export const getters = {
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
    if (state.eventSelected) {
      return state.events[state.eventSelected].service;
    } else {
      return {};
    }
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
    // console.log(calendar, hour, type, state.coordinates[calendar][hour][type]);
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
  getPreEvents: state => {
    return state.preEvents;
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
    return state.date.day() + 1;
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