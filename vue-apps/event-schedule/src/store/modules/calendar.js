import Moment from 'moment';
import tz from 'moment-timezone'
import 'moment/locale/es';
import {extendMoment} from 'moment-range';

const moment = extendMoment(Moment);

import {
  SET_CALENDAR_DATE
} from './../mutation-types'

export default {
  namespaced: false,
  state: {
    calendarDate: moment().tz('America/Argentina/Buenos_Aires').locale('es'),
    calendarMonths: ['01','02','03','04','05','06','07','08','09','10','11','12']
  },
  mutations: {
    [SET_CALENDAR_DATE](state, newDate) {
      state.calendarDate = newDate;
    },
  },
  getters: {
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

        let firstWeekDay = moment().year(getters.getCalendarYear).month(getters.getCalendarMonth).week(weeknumber).day(1);
        let lastWeekDay = moment().year(getters.getCalendarYear).month(getters.getCalendarMonth).week(weeknumber).day(7);

        if (getters.getCalendarMonth == 12 && (weeks.length - 1) == index) {
          firstWeekDay = moment().year(getters.getCalendarYear).month(getters.getCalendarMonth).week(weeks[index - 1]).day(0);
          firstWeekDay.add(7, "day");
          lastWeekDay = moment().year(getters.getCalendarYear).month(getters.getCalendarMonth).week(weeks[index - 1]).day(6);
          lastWeekDay.add(6, "day");
        }
        //console.log("From", firstWeekDay.format("YYYY-MM-DD"), weeknumber, "To", lastWeekDay.format("YYYY-MM-DD"), weeknumber);
        weekRange = moment.range(firstWeekDay, lastWeekDay)
        calendar.push(weekRange)
      }
      return calendar
    },

  }
}
