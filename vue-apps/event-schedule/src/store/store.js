import Vue from 'vue'
import Vuex from 'vuex'

import moment from 'moment'

import 'moment/locale/es';


import {calculateDistance, getRandomColor} from './../utils/helpers'


import {EventService, StartService, CalendarService, ServiceService, CategoryService} from '../resource'

import datesModule from './modules/dates'
import calendarModule from './modules/calendar'
import helperModule from './modules/helpers'

import {CONF_PRE_EVENT_SIZE} from './../config/config'


import has from 'lodash.has'

import {
  SET_SERVICE_ID_SELECTED,
  SET_SERVICE_SELECTED,
  SET_DATE,
  ADD_CALENDAR,
  SET_CALENDARS,
  HIDE_CALENDAR,
  SHOW_CALENDAR,
  SET_PRE_EVENTS,
  SET_EVENTS,
  CLEAR_EVENTS,
  ADD_EVENT,
  UPDATE_EVENT,
  REMOVE_PRE_EVENTS,
  SET_CALENDAR_SCROLL,
  SET_EVENT_STATES,
  SET_EVENT_TYPES,
  SET_ZONES,
  HIDE_ZONE,
  SHOW_ZONE,
  SET_CELL_HEIGHT,
  SET_FILTER_ZONE,
  SET_FILTER_STRING,
  SET_FILTER_HOURS,
  ADD_PRE_EVENT,
  REMOVE_EVENT,
  SET_EVENT_ID_SELECTED,
  SET_EVENT_INDEX_SELECTED,
  SET_SHOW_MODAL_FORM,
  SET_EVENT_SELECTED,
  SET_CALENDAR_START,
  SET_CALENDAR_GROUPS,
  SET_CALENDAR_GROUP_SELECTED,
  SET_FILTER_COOP,
  SET_OUTOFSERVICE_CALENDAR,
  SET_HOLIDAYS,
  SET_SHOW_MODAL_SERVICE,
  SET_PRE_EVENT_SIZE,
  SET_PRE_EVENT_FILTERED_SIZE, PLUS_PRE_EVENT_LIST_PAGE, CLEAR_PRE_EVENTS,
} from './mutation-types'
import {ADD_PRE_EVENT_UNSHIFT, SET_CATEGORIES, SET_FILTER_CATEGORY} from "@/store/mutation-types";


Vue.use(Vuex)


/*
*
* STATE
*
*/

const state = {
  filterHour: {from: null, to: null},
  filterCoop: null,
  filterZone: null,
  filterString: null,
  filterCategory: null,
  calendarStart: "06:00",
  eventIndexSelected: null,
  eventIdSelected: null,
  eventSelected: null,
  serviceSelected: null,
  serviceIdSelected: null,
  showModalForm: false,
  showModalServiceEvents: false,
  cellHeight: 60,
  calendarPosition: {top: 0, left: 0},
  calendarScroll: {top: 0, left: 0},
  calendars: [],
  calendarGroups: [],
  calendarGroupSelected: null,
  vcalendars: [],
  preEvents: [],
  preEventsByZone: {},
  events: [],
  eventStates: [],
  zones: {},
  categories: {},
  holidays: [],
  eventTypes: [],
  preEventSize: CONF_PRE_EVENT_SIZE,
  preEventFilteredSize: 0,
  preEventListLimit: 500,
  preEventListPage: 1
};

/*
*
* GETTERS
*
*/

const getters = {

  getServiceIdSelected: state => {
    return state.serviceIdSelected;
  },

  hasMorePreEvents: state => {
    if (state.preEventFilteredSize > state.preEventSize) {
      return true
    }
    return false
  },

  isHoliday: (state, getters) => {
    if (state.holidays && state.holidays.find(h => h.date == getters.getDate)) {
      return true
    }
    return false
  },
  getCalendars: state => {
    return state.calendars;
  },
  getCalendarById: state => (id) => {
    return state.calendars.find(e => e.id == id);
  },
  getZones: state => {
    return state.zones;
  },
  getCategories: state => {
    return state.categories;
  },
  getDistanceFromEventSelected: (state) => (dlat, dlng) => {
    if (state.eventIndexSelected != undefined && state.eventSelected.lat != undefined && state.eventSelected.lng != undefined) {

      var lat = state.eventSelected.lat;
      var lng = state.eventSelected.lng;
      var distance = calculateDistance(lat, lng, dlat, dlng);
      return parseFloat(Math.round(distance * 100) / 100).toFixed(2);

    }
    return null;
  },
  getEventsByCalendar: (state) => (index) => {
    return state.events.filter(e => e.calendar == index);
  },
  getServiceSelected: state => {
    if (state.eventSelected != undefined && state.eventSelected != null) {
      if (state.events[state.eventSelected] != undefined && state.events[state.eventSelected].serviceDescription != undefined) {
        return state.events[state.eventSelected].serviceDescription;
      }
    }
    return {};
  },
  isVisibleCalendar: (state) => (id) => {
    var calendar = state.calendars.find(calendar => calendar.id === id);
    if (calendar != undefined && calendar.hidden == true) {
      return false
    }
    return true
  },
  getCalendarSchedule: (state) => (id, day) => {
    var calendar = state.calendars.find(calendar => calendar.id === id);
    return calendar.schedules.find(schedule => schedule.day === day);
  },
  getVisibleCalendars: state => {
    if (state.calendars) {
      return state.calendars.filter(calendar => calendar.hidden != true)
    }
    return []
  },
  hasCalendars: (state) => {
    if (state.calendars != undefined && state.calendars.length > 0) {
      return true;
    }
    return false;
  },
  getPreEventIndexById: (state) => (id) => {
    return state.preEvents.findIndex(e => e.id === id)
  },
  getPreEventById: (state) => (id) => {
    return state.preEvents.map(function (x) {
      return x.id;
    }).indexOf(id);
  },
  getPreEventsFiltered: (state, getters) => {
    var pes = state.preEvents;

    if (!pes) {
      pes = []
    }

    //FILTER
    if (state.filterZone || state.filterString || state.filterCoop || state.filterHour.from || state.filterHour.to || state.filterCategory) {

      pes = state.preEvents.filter(function (e) {


        if (state.filterCoop && e.link != state.filterCoop) {
          return false
        }

        if (state.filterCategory && e.category && e.category.id && e.category.id != state.filterCategory) {
          return false
        }

        if(state.filterCategory && !e.category){
          return false
        }

        if (state.filterZone && e.zone && e.zone.id && e.zone.id != state.filterZone) {
          return false
        }

        if (state.filterZone && !e.zone){
          return false
        }


        if (state.filterString && //Si existe filtro string
            (e.client && e.client.toLowerCase().indexOf(state.filterString) == -1) && //Y no coincide con nombre cliente
            (e.location && e.location.toLowerCase().indexOf(state.filterString) == -1) && //Y tampoco coincide con la locacion
            (e.branchOffice && e.branchOffice.toLowerCase().indexOf(state.filterString) == -1) && // y tampoco coincide con la sucursal
            state.filterString != e.id) { //y tampoco coincide con el ID
          return false;
        }


        if (state.filterHour.from && state.filterHour.to) {
          //Two Range
          if (
            has(e, 'config.availability.timeRange.from') &&
            has(e, 'config.availability.timeRange.to') &&
            has(e, 'config.availability.timeRange2.from') &&
            has(e, 'config.availability.timeRange2.to')
          ) {
            //Compruebo el  primer Rango
            if (state.filterHour.from > e.config.availability.timeRange.from ||
              state.filterHour.to < e.config.availability.timeRange.to) {

              //Compruebo el segundo Rango
              if (state.filterHour.from > e.config.availability.timeRange2.from ||
                state.filterHour.to < e.config.availability.timeRange2.to
              ) {
                return false
              }
            }
            //One Range
          } else if (
            has(e, 'config.availability.timeRange.from') &&
            has(e, 'config.availability.timeRange.to')
          ) {
            //Invertido (Si el from del evento es mayor al to y los filtros no estan invertidos)
            if (e.config.availability.timeRange.from > e.config.availability.timeRange.to &&
              state.filterHour.from < state.filterHour.to) {
              return false
              //Normal
            } else if (state.filterHour.from > e.config.availability.timeRange.from ||
              state.filterHour.to < e.config.availability.timeRange.to) {
              return false
            }
          }


        } else if (state.filterHour.from) {

          //Si ambos from estan seteados, ambos deben ser mayor para omitir el item
          if (has(e, 'config.availability.timeRange.from') && has(e, 'config.availability.timeRange2.from')) {
            if (state.filterHour.from > e.config.availability.timeRange.from
              && state.filterHour.from > e.config.availability.timeRange2.from) {
              return false
            }
            //Si solo esta seteado el primer from, debe ser mayor para omitir el item
          } else if (has(e, 'config.availability.timeRange.from')) {
            if (state.filterHour.from > e.config.availability.timeRange.from) {
              return false
            }
          }


        } else if (state.filterHour.to) {
          if (has(e, 'config.availability.timeRange.to') && has(e, 'config.availability.timeRange2.to')) {
            if (state.filterHour.to < e.config.availability.timeRange.to &&
              state.filterHour.to < e.config.availability.timeRange2.to) {
              return false
            }
          } else if (has(e, 'config.availability.timeRange.to')) {
            if (state.filterHour.to < e.config.availability.timeRange.to) {
              return false
            }
          }
        }
        return true;
      });
    }

    //SORT
    for (var i = 0; i < pes.length; i++) {
      var priority = "5";
      var lengthPriority = "8";
      if (pes[i].config && pes[i].config.availability) {
        //Verifico Dias Especificos
        if (pes[i].config.availability.especificDays != undefined) {
          for (var u = 0; u < pes[i].config.availability.especificDays.length; u++) {
            if (pes[i].config.availability.especificDays[u].day != undefined && pes[i].config.availability.especificDays[u].ordinal != undefined) {
              //Exclusivo = 1
              if (pes[i].config.availability.especificDays[u].day == getters.getDay
                && pes[i].config.availability.especificDays[u].ordinal == getters.getNumberOfDayInMonth) {
                priority = "1";
                break;
              } else {
                priority = "4";
              }
            }
          }

        } else if (pes[i].config.availability.days != undefined) {
          //Dia ok = 2
          if (pes[i].config.availability.days[getters.getDay] == true) {
            priority = "2";
          } else {
            //Dia No ok = 3
            priority = "3";
          }
          //Priorizo segun cantidad dias true
          var size = 0;
          for (var key in pes[i].config.availability.days) {
            if (pes[i].config.availability.days[key] == true) size++;
          }
          lengthPriority = size.toString()
        } else {
          priority = "5";
        }
      }

      if (pes[i].config && pes[i].config.availability && pes[i].config.availability.timeRange && pes[i].config.availability.timeRange.from) {
        pes[i].priority = parseInt(priority + "" + lengthPriority + "" + pes[i].config.availability.timeRange.from.replace(":", ""));
      } else {
        pes[i].priority = priority + "" + lengthPriority + "0000";
      }
    }

    pes.sort(function compareNumbers(a, b) {
      return a.priority - b.priority;
    });

    //TODO Mutation on Getter (Bad practice)
    state.preEventFilteredSize = pes.length;

    return pes.slice(0, state.preEventSize);
  },
  getPreEventsByZone: (state) => (id) => {
    return state.preEvents.filter(function (el) {
        if (el.zone != undefined && el.zone.id != undefined && el.zone.id == id) {
          return true;
        }
        return false;
      }
    );
  },
  getPreEventsByCategory: (state) => (id) => {
    return state.preEvents.filter(function (el) {
          if (el.category != undefined && el.category.id != undefined && el.category.id == id) {
            return true;
          }
          return false;
        }
    );
  },
  getZoneColor: (state) => (id) => {
    if (state.zones[id] != undefined && state.zones[id].color != undefined) {
      return state.zones[id].color;
    }
    return "#000000";
  },
  getZoneBgColor: (state) => (id) => {
    if (state.zones[id] != undefined && state.zones[id].bgColor != undefined) {
      return state.zones[id].bgColor;
    }
    return "";
  },
  getEventStateById: (state) => (id) => {
    return state.eventStates.find(eventState => eventState.id === id)
  },
  getEventStateBgColor: (state, getters) => (stateId) => {
    var state = getters.getEventStateById(stateId);
    if (state != undefined && state.bgColor != undefined && state.bgColor != "") {
      return state.bgColor;
    }
    //indigo lighten-2 - #7986CB
    return '#7986CB';
  },
  getEventStateColor: (state, getters) => (stateId) => {
    var state = getters.getEventStateById(stateId);
    if (state != undefined && state.color != undefined && state.color != "") {
      return state.color;
    }
    return '#FFFFFF';
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
  getEventIndexById: (state) => (id) => {
    return state.events.findIndex(e => e.id === id)
  },
  getEventByTd: (state) => (calendar, start, end) => {
    return state.events.filter(function (e) {
      if (e.calendar == calendar && e.start >= start && e.start < end) {
        return true;
      }
      return false;
    });
  }, getStart: (state) => {
    return state.calendarStart;
  },
  getEnd: (state, getters) => {
    var rend = null;
    if (getters.hasCalendars) {
      for (var index = 0; index < state.calendars.length; ++index) {
        if (state.calendars[index].schedules != undefined) {
          var schedule = state.calendars[index].schedules.find(schedule => schedule.day == getters.getDay);
          if (schedule != undefined) {

            if (schedule.end2 != undefined && schedule.end2 > rend) {
              rend = schedule.end2;
            } else if (schedule.end != undefined && schedule.end > rend) {
              rend = schedule.end;
            }
          }
        }
      }
    }
    if (rend == null) rend = "23:59";
    return rend;
  },
  getNextStart: () => {
    var rstart = "00:00";
    return rstart;
  },
  getNextEnd: (state, getters) => {
    var rend = "00:01";
    if (getters.hasCalendars) {
      for (var index = 0; index < state.calendars.length; ++index) {
        if (state.calendars[index].schedules != undefined) {
          var schedule = state.calendars[index].schedules.find(schedule => schedule.day == getters.getNextDay);
          if (schedule != undefined && schedule.start != undefined && schedule.end != undefined) {
            if (schedule.start == '00:00' && schedule.end > rend) {
              rend = schedule.end;
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

      var t = moment(state.calendarStart, "HH:mm");
      if (!t.isValid()) {
        console.log("GET HOURS - t - Fecha no valida")
        return hours;
      }

      var e = moment("23:59", "HH:mm");
      if (!e.isValid()) {
        console.log("GET HOURS - e - Fecha no valida")
        return hours;
      }

      var calls = 0;

      while (flag) {
        hours.push(t.format("HH:mm"));
        t.add(30, "minutes");
        if (t >= e) {
          flag = false;
        }
        //Prevent Infinity Loop
        calls += 1;
        if (calls > 100) {
          // debugger;
          flag = false;
          console.log("Loop: getHours");
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


  selectEvent({commit, getters}, event) {
    commit(SET_EVENT_SELECTED, event);
    commit(SET_EVENT_ID_SELECTED, event.id);
    commit(SET_EVENT_INDEX_SELECTED, getters.getEventIndexById(event.id));
  },

  clearSelectEvent({commit}) {
    commit(SET_EVENT_SELECTED, null);
    commit(SET_EVENT_ID_SELECTED, null);
    commit(SET_EVENT_INDEX_SELECTED, null);
  },

  selectService({commit}, id) {
    commit('SET_SERVICE_ID_SELECTED', id);
    ServiceService.fetch(id).then(
      (response) => {
        let service = response.data;

        //TODO AltoParche (Corregir por favor...)
        if (service && service.cliente && service.cliente.nombre) {
          service.client = {name: service.cliente.nombre};
        }
        if (service && service.nombre) {
          service.name = service.nombre;
        }
        if (service && service.sucursal && service.sucursal.nombre) {
          service.branchOffice = {name: service.sucursal.nombre};
          if (service.sucursal.direccion) {
            service.branchOffice.location = service.sucursal.direccion;
          }
        }


        commit('SET_SERVICE_SELECTED', service);
      }
    )
  },
  checkOutOfService({state, getters, commit}) {
    let value = false;
    //Recorro los calendarios
    for (let i = 0; i < state.calendars.length; i++) {
      let calendar = state.calendars[i]
      value = false;
      if (calendar.outOfServices && calendar.outOfServices.length > 0) {
        //Recorro los OutOfService del calendario
        for (let u = 0; u < calendar.outOfServices.length; u++) {
          let oof = calendar.outOfServices[u]
          if (getters.getDate >= oof.start && getters.getDate <= oof.end) {
            value = true;
          }
        }
      }
      commit(SET_OUTOFSERVICE_CALENDAR, {index: i, value: value});
    }
  },
  checkCoop({state, commit}) {
    if (state.filterCoop) {
      if (!state.preEvents.find(e => e.link === state.filterCoop)) {
        commit(SET_FILTER_COOP, null);
      }
    }
  },
  changeDate({commit, dispatch}, date) {
    var newDate = moment(date)
    if (newDate.isValid()) {

      let promise = new Promise((f) => {
        f()
      })

      promise.then(function () {
        commit(SET_DATE, newDate);
        commit(CLEAR_EVENTS);
        commit(CLEAR_PRE_EVENTS);
        commit(SET_EVENT_SELECTED, null);
        commit(SET_EVENT_INDEX_SELECTED, null);
        commit(SET_EVENT_ID_SELECTED, null);
        commit(SET_PRE_EVENT_SIZE, CONF_PRE_EVENT_SIZE);
      }).then(
        function () {
          dispatch('eventList').then(
            dispatch('preEventList').then(
              dispatch('checkOutOfService')
            )
          )


        }
      ).catch(
        () => {
          dispatch("setTextError", "Error on changeDate");
        }
      );


    }
  },

  getRandomColor: function () {
    return '#' + (Math.random() * 0xFFFFFF << 0).toString(16);
  },

  startList({commit, dispatch}) {

    StartService.start().then((response) => {

      commit(SET_CALENDARS, response.data.calendars);
      commit(SET_CALENDAR_GROUPS, response.data.calendarGroups);
      commit(SET_EVENT_STATES, response.data.eventStates);
      commit(SET_EVENT_TYPES, response.data.eventTypes);
      commit(SET_HOLIDAYS, response.data.holidays);
      if (response.data.zones) {
        dispatch('populateZones', response.data.zones);
      }
      dispatch('fetchCategories');
      dispatch('eventList');
      dispatch('preEventList');
    })

  },

  populateZones: ({commit}, data) => {
    var zones = {};
    for (var i = 0; i < data.length; i++) {
      var zone = data[i];
      if (zone.bgColor == undefined) {
        zone.bgColor = getRandomColor();
      }
      zones[zone.id] = zone;
    }
    commit("SET_ZONES", zones);
  },

  fetchCategories: ({commit}) => {
    return CategoryService.findAll().then((response) => {
      commit(SET_CATEGORIES, response.data);
    });

  },


  calendarList({ commit, dispatch}) {
    CalendarService.findAll().then((response) => {
      commit(SET_CALENDARS, response.data);

    }).catch(
      () => {
        dispatch("setTextError", "Error on calendarList");
      }
    );
  },

  preEventList({commit, getters, state}) {

      return EventService.getPreEvents(getters.getDate, state.preEventListLimit, state.preEventListPage).then((response) => {
        commit("SET_PRE_EVENTS", response.data);
        //commit(PLUS_PRE_EVENT_LIST_PAGE);
      });


  },

  eventList({getters, commit, dispatch}) {

    return EventService.getActiveEvents(getters.getDate, getters.getNextDate, getters.getNextEnd).then(
      (response) => {
        var events = [];
        for (let i = 0; i < response.data.length; i++) {
          let event = response.data[i];
          if (event.calendar != null) {
            event.hour = moment(event.start).tz('America/Argentina/Buenos_Aires').format("HH:mm");
            events.push(event);
          }
        }
        commit("SET_EVENTS", events);
      }
    ).catch(
      () => {
        dispatch("setTextError", "Error on eventList");
      }
    );
  },
  pushEvent({ getters, commit, dispatch}, event) {
    event.hour = moment(event.start).tz('America/Argentina/Buenos_Aires').format("HH:mm");
    commit('ADD_EVENT', event);

    EventService.updateEvent(event).then(() => {
      dispatch('checkCoop')
    }).catch(
      () => {
        commit('REMOVE_EVENT', getters.getEventIndexById(event.id))
      }
    );

  },
  updateEvent({ commit, dispatch}, {index, event}) {
    EventService.updateEvent(event).then(
      () => {
        commit('UPDATE_EVENT', {index: index, event: event})
      }
    ).catch(
      () => {
        dispatch("setTextError", "Error on updateEvent");
      }
    );
  },
  refreshEvent({ getters, commit, dispatch}, event) {
    EventService.updateEvent(event).then(
      () => {

        let indexPreEvent = getters.getPreEventIndexById(event.id);
        if (indexPreEvent) {
          commit('REMOVE_PRE_EVENTS', indexPreEvent)
        }

        let indexEvent = getters.getEventIndexById(event.id);
        if (indexEvent) {
          commit('UPDATE_EVENT', {index: indexEvent, event: event})
        } else {
          commit('ADD_EVENT', event);
        }

      }
    ).catch(
      () => {
        dispatch("setTextError", "Error on refreshEvent");
      }
    );
  }
};

const mutations = {

  [SET_SERVICE_ID_SELECTED](state, id) {
    state.serviceIdSelected = id;
  },
  [SET_SERVICE_SELECTED](state, service) {
    state.serviceSelected = service;
  },
  [ADD_CALENDAR](state, calendar) {
    state.calendars.push(calendar);
  },
  [SET_OUTOFSERVICE_CALENDAR](state, {index, value}) {
    Vue.set(state.calendars[index], 'outOfService', value);
  },
  [SET_HOLIDAYS](state, holidays) {
    state.holidays = holidays;
  },
  [SHOW_CALENDAR](state, index) {
    Vue.set(state.calendars[index], 'hidden', false);
  },
  [HIDE_CALENDAR](state, index) {
    Vue.set(state.calendars[index], 'hidden', true)
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

    if(state.preEvents.length > 0) {

      preEvents.forEach(pe => {
        if (state.preEvents.findIndex(item => item.id == pe.id) == -1) {
          state.preEvents.push(pe)
        }
      })
    }else{
      state.preEvents = preEvents;
    }

  },
  [CLEAR_PRE_EVENTS](state) {
    state.preEvents = []
  },
  [REMOVE_PRE_EVENTS](state, index) {
    state.preEvents.splice(index, 1);
  },
  [ADD_PRE_EVENT](state, event) {
    state.preEvents.push(event);
  },
  [ADD_PRE_EVENT_UNSHIFT](state, event) {
    state.preEvents.unshift(event);
  },
  [SET_EVENT_INDEX_SELECTED](state, index) {
    state.eventIndexSelected = index;
  },
  [SET_EVENT_ID_SELECTED](state, id) {
    state.eventIdSelected = id;
  },
  [SET_EVENTS](state, events) {
    state.events = events;
  },
  [CLEAR_EVENTS](state) {
    state.events = []
  },

  [ADD_EVENT](state, event) {
    state.events.push(event);
  },
  [REMOVE_EVENT](state, index) {
    state.events.splice(index, 1);
  },
  [UPDATE_EVENT](state, {index, event}) {
    state.events[index] = event;
  },
  [SET_CALENDAR_SCROLL](state, {top, left}) {
    state.calendarScroll.top = top;
    state.calendarScroll.left = left;
  },
  [SET_CELL_HEIGHT](state, cellHeight) {
    state.cellHeight = cellHeight;
  },
  [SET_FILTER_ZONE](state, filterZoneId) {
    state.filterZone = filterZoneId;
  },
  [SET_FILTER_CATEGORY](state,categoryId){
    state.filterCategory = categoryId;
  },
  [SET_FILTER_STRING](state, filterString) {
    state.filterString = filterString;
  },
  [SET_EVENT_SELECTED](state, event) {
    state.eventSelected = event;
  },
  [SET_SHOW_MODAL_FORM](state, value) {
    state.showModalForm = value;
  },
  [SET_SHOW_MODAL_SERVICE](state, value) {
    state.showModalServiceEvents = value;
  },
  [SET_CALENDAR_START](state, value) {
    state.calendarStart = value;
  },
  [SET_CALENDAR_GROUPS](state, value) {
    state.calendarGroups = value;
  },
  [SET_CALENDAR_GROUP_SELECTED](state, value) {
    state.calendarGroupSelected = value;
  },
  [SET_FILTER_COOP](state, link) {
    state.filterCoop = link;
  },
  [SET_FILTER_HOURS](state, filterHour) {
    state.filterHour.from = filterHour.from;
    state.filterHour.to = filterHour.to;
  },
  [SET_PRE_EVENT_SIZE](state, size) {
    state.preEventSize = size;
  },
  [SET_PRE_EVENT_FILTERED_SIZE](state, size) {
    state.preEventFilteredSize = size;
  },
  [PLUS_PRE_EVENT_LIST_PAGE](state) {
    state.preEventListPage++;
  },
  [SET_CATEGORIES](state, categories){
    state.categories = categories
  }
};


const store = new Vuex.Store({
  state,
  getters,
  actions,
  mutations,
  modules: {
    dates: datesModule,
    calendar: calendarModule,
    helpers: helperModule
  }
});


export default store;
