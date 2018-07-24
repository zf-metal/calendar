import {state} from './state'
import {getters} from './getters'
import {HTTP} from './../utils/http-client'
import moment from 'moment'
import tz from 'moment-timezone'
import 'moment/locale/es';

import {
  SET_DATE,
  ADD_CALENDAR, SET_CALENDARS, HIDE_CALENDAR, SHOW_CALENDAR,
  SET_PRE_EVENTS, SET_EVENTS, CLEAR_EVENTS, ADD_EVENT, UPDATE_EVENT, REMOVE_PRE_EVENTS,
  SET_COORDINATE, SET_BODY_SCROLL, SET_CALENDAR_SCROLL, SET_CALENDAR_POSITION,
  SET_EVENT_STATES, SET_EVENT_TYPES, SET_EVENT_SELECTED
} from './mutation-types'

export const actions = {
  hideCalendar({commit, dispatch, state}, index) {
    commit('HIDE_CALENDAR', index);
  },
  showCalendar({commit, dispatch}, index) {
    commit('SHOW_CALENDAR', index);
  },
  changeDate({state, commit, dispatch}, date) {
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
  preEventList({commit}) {
    state.loading = state.loading + 1;
    HTTP.get('events?calendar=isNull&dateFrom=<=' + getters.getDate()).then((response) => {
      commit("SET_PRE_EVENTS", response.data);
      state.loading = state.loading - 1;
    })
  },
  eventList({state, getters, commit, dispatch}) {
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
  pushEvent({state, commit, getters}, event) {
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
  updateEvent({state, commit, getters}, {index, event}) {

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