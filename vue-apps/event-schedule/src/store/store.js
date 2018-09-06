import Vue from 'vue'
import Vuex from 'vuex'

import moment from 'moment'
import tz from 'moment-timezone'
import 'moment/locale/es';

import {HTTP} from './../utils/http-client'
import {calculateDistance, getRandomColor, extractPriorityIntByTime} from './../utils/helpers'

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
    SET_BODY_SCROLL,
    SET_CALENDAR_SCROLL,
    SET_CALENDAR_POSITION,
    SET_EVENT_STATES,
    SET_EVENT_TYPES,
    SET_ZONES,
    HIDE_ZONE,
    SHOW_ZONE,
    SET_CELL_HEIGHT,
    UPDATE_RC,
    SET_FILTER_ZONE,
    SET_FILTER_STRING,
    LOADING_LESS,
    LOADING_PLUS,
    ADD_PRE_EVENT,
    REMOVE_EVENT,
    SET_EVENT_FORM,
    SET_EVENT_ID_SELECTED,
    SET_EVENT_INDEX_SELECTED,
    SET_SHOW_MODAL_FORM,
    SET_EVENT_SELECTED,
    SET_CALENDAR_START,
    SET_CALENDAR_GROUPS,
    SET_CALENDAR_GROUP_SELECTED
} from './mutation-types'

Vue.use(Vuex)


/*
*
* STATE
*
*/

const state = {
    calendarStart: "00:00",
    eventIndexSelected: null,
    eventIdSelected: null,
    eventSelected: {},
    showModalForm: false,
    filterZone: null,
    filterString: null,
    cellHeight: 60,
    loading: 0,
    coordinates: {},
    calendarPosition: {top: 0, left: 0},
    bodyScroll: {top: 0, left: 0},
    calendarScroll: {top: 0, left: 0},
    date: moment().tz('America/Argentina/Buenos_Aires').locale('es'),
    nextDate: null,
    calendars: [],
    calendarGroups: [],
    calendarGroupSelected: null,
    vcalendars: [],
    rc: 1,
    preEvents: [],
    preEventsByZone: {},
    events: [],
    eventStates: [],
    zones: {},
    hiddenZones: [],
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
    getGroupSelected: state => {
        return state.calendarGroupSelected;
    },
    getCalendarsGroups: state => {
        return state.calendarGroups;
    },
    getCalendarStart: state => {
        return state.calendarStart;
    },
    getShowModalForm: state => {
        return state.showModalForm;
    },
    getEventForm: state => {
        return state.eventSelected;
    },
    getEventSelected: state => {
        return state.eventSelected;
    },
    getEventIndexSelected: state => {
        return state.eventIndexSelected;
    },
    getEventIdSelected: state => {
        return state.eventIdSelected;
    },
    getCalendarScroll: state => {
        return state.calendarScroll;
    },
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
        if (state.eventIndexSelected != undefined && state.eventSelected.lat != undefined && state.eventSelected.lng != undefined) {

            var lat = state.eventSelected.lat;
            var lng = state.eventSelected.lng;
            var distance = calculateDistance(lat, lng, dlat, dlng);
            return parseFloat(Math.round(distance * 100) / 100).toFixed(2);

        }
        return '-';
    },
    getEventSelected: state => {
        return state.eventSelected;
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
    getRc: state => {
        return state.rc
    },
    getCoordinates: state => {
        return state.coordinates;
    },
    getLoading: state => {
        return state.loading;
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
    getPreEventByKey: (state) => (key) => {
        return state.preEvents[key];
    },
    getPreEvents: state => {
        return state.preEvents;
    },
    getPreEventsFiltered: (state, getters) => {
        var pes = state.preEvents;

        store.commit(LOADING_PLUS);
        //FILTER
        if ((state.filterZone != null && state.filterZone != "") || (state.filterString != null && state.filterString != "")) {
            pes = state.preEvents.filter(function (e) {
                if (
                    ((e.zone != undefined && e.zone.id != undefined && (state.filterZone == null || state.filterZone == "" || e.zone.id == state.filterZone)) || (e.zone == undefined && (state.filterZone == undefined || state.filterZone == "" ))) &&
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
            if (pes[i].availability != undefined) {
                //Verifico Dias Especificos
                if (pes[i].availability.especificDays != undefined) {
                    for (var u = 0; u < pes[i].availability.especificDays.length; u++) {
                        if (pes[i].availability.especificDays[u].day != undefined && pes[i].availability.especificDays[u].ordinal != undefined) {
                            //Exclusivo = 1
                            if (pes[i].availability.especificDays[u].day == getters.getDay
                                && pes[i].availability.especificDays[u].ordinal == getters.getNumberOfDayInMonth) {
                                priority = "1";
                                break;
                            } else {
                                priority = "4";
                            }
                        }
                    }

                } else if (pes[i].availability.days != undefined) {
                    //Dia ok = 2
                    if (pes[i].availability.days[getters.getDay] == true) {
                        priority = "2";
                    } else {
                        //Dia No ok = 3
                        priority = "3";
                    }

                    //Priorizo segun cantidad dias true
                    var size = 0;
                    for (var key in pes[i].availability.days) {
                        if (pes[i].availability.days[key] == true) size++;
                    }
                    lengthPriority = size.toString()

                } else {
                    priority = "5";
                }

            }

            if (pes[i].availability && pes[i].availability.timeRange && pes[i].availability.timeRange.from) {
                pes[i].priority = parseInt(priority + "" + lengthPriority + "" + pes[i].availability.timeRange.from.replace(":", ""));
            } else {
                pes[i].priority = priority + "" + lengthPriority + "0000";
            }


        }


        pes.sort(function compareNumbers(a, b) {
            return a.priority - b.priority;
        });

        store.commit(LOADING_LESS);
        return pes;
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
    getEventIndexById: (state) => (id) => {
        return state.events.findIndex(e => e.id === id)
    },
    getEventByTd: (state, getters) => (calendar, start, end) => {
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
        return this.calendarStart;
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
    getNextStart: (state, getters) => {
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
            var t = moment(getters.getCalendarStart, "HH:mm");
            var e = moment("23:59", "HH:mm");
            while (flag) {
                hours.push(t.format("HH:mm"));
                t.add(30, "minutes");
                if (t >= e) {
                    flag = false;
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
            while (flag) {
                hours.push(t.format("HH:mm"));
                t.add(30, "minutes");
                if (t >= e) {
                    flag = false;
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
    startList({commit, dispatch}) {
        state.loading = state.loading + 1;
        HTTP.get('start').then((response) => {
            commit(SET_CALENDARS, response.data.calendars);
            commit(SET_CALENDAR_GROUPS, response.data.calendarGroups);
            commit(SET_EVENT_STATES, response.data.eventStates);
            commit(SET_EVENT_TYPES, response.data.eventTypes);

            var zones = {};
            for (var i = 0; i < response.data.zones.length; i++) {
                var zone = response.data.zones[i];
                if (zone.bgColor == undefined) {
                    zone.bgColor = getRandomColor();
                }
                zones[zone.id] = zone;
            }
            commit("SET_ZONES", zones);
            dispatch('eventList');

            state.loading = state.loading - 1;
        })
    },
    eventStateList({commit}) {
        state.loading = state.loading + 1;
        HTTP.get('event-states').then((response) => {
            commit("SET_EVENT_STATES", response.data);
            state.loading = state.loading - 1;
        })
    },
    zoneList({commit}) {
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
            commit("SET_PRE_EVENTS", response.data);
            state.loading = state.loading - 1;
        });
    },
    eventList({state, getters, commit}) {
        state.loading = state.loading + 1;
        HTTP.get("events?calendar=isNotNull&start=" + getters.getDate + "<>" + getters.getNextDate + " " + getters.getNextEnd
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
    hideZone({commit}, index) {
        commit('HIDE_ZONE', index);
    },
    showZone({commit}, index) {
        commit('SHOW_ZONE', index);
    },
    setVisibleCalendarByGroup({state, commit}, groupSelected) {
        commit('SET_CALENDAR_GROUP_SELECTED', groupSelected);
        for (var i = 0; i < state.calendars.length; i++) {
            if (state.calendars[i].groups && state.calendars[i].groups.find(group => group.id == groupSelected)) {
                commit('SHOW_CALENDAR', i);
            } else {
                commit('HIDE_CALENDAR', i);
            }
        }
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
            commit(SET_EVENT_SELECTED, null);
            commit(SET_EVENT_INDEX_SELECTED, null);
            commit(SET_EVENT_ID_SELECTED, null);
            dispatch('eventList');
        }
    },
    getRandomColor: function () {
        return '#' + (Math.random() * 0xFFFFFF << 0).toString(16);
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
        state.coordinates = {};
        state.date = newDate;
        state.rc++;
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
    [SET_CALENDAR_POSITION](state, {top, left}) {
        state.calendarPosition.top = top;
        state.calendarPosition.left = left;
    },
    [SET_BODY_SCROLL](state, {top, left}) {
        state.bodyScroll.top = top;
        state.bodyScroll.left = left;
    },
    [SET_CALENDAR_SCROLL](state, {top, left}) {
        //console.log(top,left);
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
    },
    [LOADING_LESS](state) {
        state.loading--;
    },
    [LOADING_PLUS](state) {
        state.loading++;
    },
    [SET_EVENT_SELECTED](state, event) {
        state.eventSelected = event;
    },
    [SET_SHOW_MODAL_FORM](state, value) {
        state.showModalForm = value;
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
};


const store = new Vuex.Store({
    state,
    getters,
    actions,
    mutations
});


export default store;