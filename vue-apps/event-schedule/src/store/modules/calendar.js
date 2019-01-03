import Moment from 'moment';
import tz from 'moment-timezone'
import 'moment/locale/es';
import {extendMoment} from 'moment-range';

const moment = extendMoment(Moment);


import {
  SET_CALENDAR_DATE,
  SET_CALENDAR_EVENTS,
  SET_CALENDAR_EVENT_SELECTED,
  SET_SHOW_CALENDAR_EVENT_MODAL,
  SET_CALENDAR_SELECTED,
  SET_HOUR_SELECTED
} from './calendar-mutations'


export default {
  namespaced: false,
  state: {
    calendarDate: moment().tz('America/Argentina/Buenos_Aires').locale('es'),
    calendarMonths: ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'],
    calendarEvents: [],
    calendarEventSelected: null,
    showCalendarEventModal: false,
    calendarSelected: null,
    hourSelected: "00:00"
  },
  actions: {

    setCalendarSelected: ({commit}, calendar) => {
      commit(SET_CALENDAR_SELECTED, calendar)
    },

    setHourSelected: ({commit}, hour) => {
      let pattern = /[012]\d:[0123456]\d/
      if (pattern.test(hour)) {
        commit(SET_HOUR_SELECTED, hour)
      }else{
        console.log("Hour format incorrect")
      }
    },

    setCalendarEvents: ({commit}, events) => {
      commit(SET_CALENDAR_EVENTS, events)
    },

    setCalendarEventSelected: ({commit}, eventSelected) => {
      commit(SET_CALENDAR_EVENT_SELECTED, eventSelected)
    },

    setShowCalendarEventModal: ({commit}, value) => {
      commit(SET_SHOW_CALENDAR_EVENT_MODAL, value)
    },
    setCalendarDate: ({commit}, date) => {
      commit(SET_CALENDAR_DATE, date)
    },
  },
  mutations: {
    [SET_CALENDAR_SELECTED](state, calendar) {
      state.calendarSelected = calendar;
    },
    [SET_HOUR_SELECTED](state, hour) {
      state.hourSelected = hour;
    },
    [SET_CALENDAR_DATE](state, newDate) {
      state.calendarDate = newDate;
    },
    [SET_CALENDAR_EVENTS](state, preEvents) {
      state.calendarEvents = preEvents;
    },
    [SET_CALENDAR_EVENT_SELECTED](state, eventSelected) {
      state.calendarEventSelected = eventSelected;
    },
    [SET_SHOW_CALENDAR_EVENT_MODAL](state, value) {
      state.showCalendarEventModal = value;
    },
  },

  getters: {
    getCalendarSelected: state => {
      return state.calendarSelected;
    },

    getHourSelected: state => {
      return state.hourSelected;
    },

    getShowCalendarEventModal: state => {
      return state.showCalendarEventModal;
    },

    getPendingCalendarEvents: state => {
      return state.calendarEvents.filter(function (e) {
        if (e.calendar == null) {
          return true;
        }
        return false;
      });
    },

    getCalendarEventSelected: state => {
      return state.calendarEventSelected;
    },

    getCalendarEvents: state => {
      return state.calendarEvents;
    },

    getRealCalendarDate: state => {
      return state.calendarDate;
    },

    getCalendarDate: state => {
      return state.calendarDate.format("YYYY-MM-DD");
    },

    getCalendarDay: state => {
      return state.calendarDate.isoWeekday();
    },

    getCalendarYear: state => {
      return state.calendarDate.format('YYYY');
    },

    getCalendarMonth: state => {
      return state.calendarDate.format('MM');
    },

    getCalendarDaysInMonth: function () {
      return null
      //return this.calendarDate.daysInMonth();
    },

    getCalendarFirstDateOfMonth: (state) => {
      return moment(state.calendarDate).startOf('month');
    },

    getCalendarEndDateOfMonth: (state) => {
      return moment(state.calendarDate).endOf('month');
    },

    getCalendarMonthRange: (state, getters) => {
      return state.calendarDate.range(getters.getCalendarFirstDateOfMonth, getters.getCalendarEndDateOfMonth);
    },

    getCalendarWeeks: (state, getters) => {
      let weeks = []
      if (state.calendarDate) {

        for (let mday of getters.getCalendarMonthRange.by('days')) {
          if (weeks.indexOf(mday.week()) === -1) {
            weeks.push(mday.week());
          }
        }
      }
      console.log(weeks);
      return weeks
    },

    getCalendarNumberOfWeeks: (state, getters) => {
      return getters.getCalendarWeeks.length
    },

    getMonthCalendar: (state, getters) => {
      let calendar = []
      let weeks = getters.getCalendarWeeks
      let weekRange = []
      for (let index = 0; index < weeks.length; index++) {
        var weeknumber = weeks[index];

        let firstWeekDay = moment().year(getters.getCalendarYear).week(weeknumber).day(0);
        let lastWeekDay = moment().year(getters.getCalendarYear).week(weeknumber).day(6);

        if (getters.getCalendarMonth == 12) {
          firstWeekDay = moment().year(getters.getCalendarYear).week(weeknumber - 1).day(0);
          firstWeekDay.add(7, "day");
          lastWeekDay = moment().year(getters.getCalendarYear).week(weeknumber - 1).day(6);
          lastWeekDay.add(7, "day");
        }
        //console.log("From", firstWeekDay.format("YYYY-MM-DD"), weeknumber, "To", lastWeekDay.format("YYYY-MM-DD"), weeknumber);
        weekRange = moment.range(firstWeekDay, lastWeekDay)
        calendar.push(weekRange)
      }
      return calendar
    },

  }
}
