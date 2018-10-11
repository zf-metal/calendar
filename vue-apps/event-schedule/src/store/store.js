import Vue from 'vue'
import Vuex from 'vuex'

import moment from 'moment'
import tz from 'moment-timezone'
import 'moment/locale/es';

import {HTTP} from './../utils/http-client'
import {calculateDistance, getRandomColor, extractPriorityIntByTime} from './../utils/helpers'


import {EventService, StartService, CalendarService} from '../resource'

import {
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
    SET_EVENT_FORM,
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
    LOADING_PLUS,
    LOADING_LESS,
    SET_SHOW_MODAL_SERVICE
} from './mutation-types'


Vue.use(Vuex)


/*
*
* STATE
*
*/

const state = {
    filterHour: {from: null, to: null},
    filterCoop: null,
    calendarStart: "06:00",
    eventIndexSelected: null,
    eventIdSelected: null,
    eventSelected: null,
    showModalForm: false,
    showModalServiceEvents: false,
    filterZone: null,
    filterString: null,
    cellHeight: 60,
    loading: 0,
    calendarPosition: {top: 0, left: 0},
    calendarScroll: {top: 0, left: 0},
    date: moment().tz('America/Argentina/Buenos_Aires').locale('es'),
    nextDate: null,
    calendars: [],
    calendarGroups: [],
    calendarGroupSelected: null,
    vcalendars: [],
    preEvents: [],
    preEventsByZone: {},
    events: [],
    eventStates: [],
    zones: {},
    holidays: [],
    eventTypes: [],
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
    isHoliday: (state, getters) => {
      if(state.holidays.find(h => h.date == getters.getDate)){
          return true
      }
      return false
    },
    getCalendars: state => {
        return state.calendars;
    },
    getZones: state => {
        return state.zones;
    },
    getDistanceFromEventSelected: (state) => (dlat, dlng) => {
        if (state.eventIndexSelected != undefined && state.eventSelected.lat != undefined && state.eventSelected.lng != undefined) {

            var lat = state.eventSelected.lat;
            var lng = state.eventSelected.lng;
            var distance = calculateDistance(lat, lng, dlat, dlng);
            return parseFloat(Math.round(distance * 100) / 100).toFixed(2);

        }
        return '-';
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
    getCalendarSchedule: (state, getters) => (id, day) => {
        var calendar = state.calendars.find(calendar => calendar.id === id);
        return calendar.schedules.find(schedule => schedule.day === day);
    },
    getVisibleCalendars: state => {
        if(state.calendars) {
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
    getPreEventById: (state) => (id) => {
        return state.preEvents.map(function (x) {
            return x.id;
        }).indexOf(id);
    },
    getPreEventsFiltered: (state, getters) => {
        var pes = state.preEvents;


        //FILTER
        if (state.filterZone || state.filterString || state.filterCoop || state.filterHour.from || state.filterHour.to) {

            pes = state.preEvents.filter(function (e) {

                if (state.filterCoop && e.link == state.filterCoop) {
                    return true
                } else if (state.filterCoop && e.link != state.filterCoop) {
                    return false
                }

                if (state.filterHour.from) {
                    if (e.config.availability && e.config.availability.timeRange && e.config.availability.timeRange.from) {
                        if (state.filterHour.from > e.config.availability.timeRange.from) {
                            return false
                        }
                    }
                }

                if (state.filterHour.to) {
                    if (e.config.availability && e.config.availability.timeRange2 && e.config.availability.timeRange2.to) {
                        if (state.filterHour.to < e.availability.timeRange2.to) {
                            return false
                        }
                    } else if (e.config.availability && e.config.availability.timeRange && e.config.availability.timeRange.to) {
                        if (state.filterHour.to < e.config.availability.timeRange.to) {
                            return false
                        }
                    }
                }

                if (
                    ((e.zone != undefined && e.zone.id != undefined && (state.filterZone == null || state.filterZone == "" || e.zone.id == state.filterZone)) || (e.zone == undefined && (state.filterZone == undefined || state.filterZone == ""))) &&
                    (state.filterString == "" || state.filterString == null || ((e.client && e.client.toLowerCase().indexOf(state.filterString) > -1) || (e.location && e.location.toLowerCase().indexOf(state.filterString) > -1) || (e.branchOffice && e.branchOffice.toLowerCase().indexOf(state.filterString) > -1)))) {
                    return true;
                }
                return false;
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

        return pes;
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
    },
    getDate: state => {
        return state.date.format("YYYY-MM-DD");
    },
    getDay: state => {
        return state.date.isoWeekday();
    },
    getNextDateObj: (state, getters) => {
        var nextDate = tz(getters.getDate);
        nextDate.add(1, 'day');
        return nextDate;
    },
    getNextDate: (state, getters) => {
        return getters.getNextDateObj.format("YYYY-MM-DD");
    },
    getNextDay: (state, getters) => {
        return getters.getNextDateObj.isoWeekday();
    },
    getNextTwoDate: (state, getters) => {
        var ntd = tz(getters.getDate);
        ntd.add(2, 'day');
        return ntd.format("YYYY-MM-DD");
    },
    getYear: state => {
        return state.date.format('YYYY');
    },
    getMonth: state => {
        return state.date.format('MM');
    },
    getMonthName: state => {
        return state.date.format('MMMM').replace(/\w/, c => c.toUpperCase());
    },
    getDayName: state => {
        return state.date.format('dddd').replace(/\w/, c => c.toUpperCase());
    },
    getNumberOfDayInMonth: state => {
        var cloneDate = state.date.clone().clone();
        var count = 0;
        var calls = 0;
        var flag = true;
        do {
            count++;
            cloneDate.subtract(1, 'week');
            //Prevent Infinity Loop
            calls += 1;
            if (calls > 10) {
                // debugger;
                flag = false;
                console.log("Loop: getNumberOfDayInMonth");
            }
        } while (state.date.month() == cloneDate.month() || flag == false)
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
    getStart: (state) => {
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
    },
    getNextHours: (state, getters) => {
        var hours = [];
        if (getters.hasCalendars) {
            var flag = true;
            var t = moment("00:00", "HH:mm");
            var e = moment(getters.getNextEnd, "HH:mm");
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
                    console.log("Loop: getNextHours");
                }
            }
        }
        return hours;
    },

};

/*
*
* ACTIONS
*
*/

const actions = {
    checkOutOfService({state,getters,commit}){
      let value = false;
      //Recorro los calendarios
        for(let i=0; i < state.calendars.length; i++){
          let calendar= state.calendars[i]
             value = false;
          if(calendar.outOfServices && calendar.outOfServices.length > 0){
              //Recorro los OutOfService del calendario
              for(let u=0;  u < calendar.outOfServices.length;u++){
                  let oof = calendar.outOfServices[u]
                  if(getters.getDate >= oof.start && getters.getDate <= oof.end){
                      value = true;
                  }
              }
          }
            commit(SET_OUTOFSERVICE_CALENDAR, {index:i,value: value});
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
            commit(SET_DATE, newDate);
            commit(CLEAR_EVENTS, newDate);
            commit(SET_EVENT_SELECTED, null);
            commit(SET_EVENT_INDEX_SELECTED, null);
            commit(SET_EVENT_ID_SELECTED, null);
            dispatch('eventList');
            dispatch('preEventList');
            dispatch('checkOutOfService')
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


    calendarList({state, commit}) {
        CalendarService.findAll().then((response) => {
            commit(SET_CALENDARS, response.data);

        })
    },

    preEventList({commit, getters, state}) {
        EventService.getPreEvents(getters.getDate).then((response) => {
            commit("SET_PRE_EVENTS", response.data);
        });
    },
    eventList({state, getters, commit}) {

        EventService.getActiveEvents(getters.getDate, getters.getNextDate, getters.getNextEnd).then(
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
        )
    },
    pushEvent({state, getters, commit, dispatch}, event) {
        event.hour = moment(event.start).tz('America/Argentina/Buenos_Aires').format("HH:mm");
        commit('ADD_EVENT', event);

        EventService.updateEvent(event).then((response) => {
            dispatch('checkCoop')
        }).catch(
            (error) => {
                commit('REMOVE_EVENT', getters.getEventIndexById(event.id))
            }
        );

    },
    updateEvent({state, commit}, {index, event}) {
        EventService.updateEvent(event).then(
            (response) => {
                commit('UPDATE_EVENT', {index: index, event: event})
            }
        ).catch(
        );
    },

};

const mutations = {
    [LOADING_PLUS](state) {
        state.loading++
    },
    [LOADING_LESS](state) {
        state.loading--
    },
    [SET_DATE](state, newDate) {
        state.date = newDate;
    },
    [ADD_CALENDAR](state, calendar) {
        state.calendars.push(calendar);
    },
    [SET_OUTOFSERVICE_CALENDAR](state, {index,value}) {
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
        state.preEvents = preEvents;
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
    [REMOVE_PRE_EVENTS](state, index) {
        state.preEvents.splice(index, 1);
    },
    [ADD_PRE_EVENT](state, event) {
        state.preEvents.push(event);
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
};


const store = new Vuex.Store({
    state,
    getters,
    actions,
    mutations
});


export default store;