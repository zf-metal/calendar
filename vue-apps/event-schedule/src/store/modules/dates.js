import Moment from 'moment';
import tz from 'moment-timezone'
import 'moment/locale/es';
import {extendMoment} from 'moment-range';

const moment = extendMoment(Moment);

import {
    SET_DATE
} from './../mutation-types'

export default {
    namespaced: false,
    state: {
        date: moment().tz('America/Argentina/Buenos_Aires').locale('es'),
        nextDate: null,
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

    },
    mutations: {
        [SET_DATE](state, newDate) {
            state.date = newDate;
        },
    },

    getters: {
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
        getFirstDateOfMonth: (state) => {
            return moment(state.date).startOf('month');
        },
        getEndDateOfMonth: (state) => {
            return moment(state.date).endOf('month');
        },
        getMonthRange: (state, getters) => {
            // console.log(" FirstDateOfMonth",getters.getFirstDateOfMonth.format("YYYY-MM-DD")," EndDateOfMonth" ,getters.getEndDateOfMonth.format("YYYY-MM-DD"))
            return state.date.range(getters.getFirstDateOfMonth, getters.getEndDateOfMonth);
        },
        getWeeks: (state, getters) => {
            let weeks = []
            if (state.date) {

                for (let mday of getters.getMonthRange.by('days')) {
                    if (weeks.indexOf(mday.week()) === -1) {
                        weeks.push(mday.week());
                    }
                }
            }
            return weeks
        },
        getNumberOfWeeks: (state, getters) => {
            return getters.getWeeks.length
        },
        getMonthCalendar: (state, getters) => {
            let calendar = []
            let weeks = getters.getWeeks
            let weekRange = []
            for (let index = 0; index < weeks.length; index++) {
                var weeknumber = weeks[index];

                let firstWeekDay = moment().year(getters.getYear).month(getters.getMonth).week(weeknumber).day(1);
                let lastWeekDay = moment().year(getters.getYear).month(getters.getMonth).week(weeknumber).day(7);

                if (getters.getMonth == 12 && (weeks.length - 1) == index) {
                    firstWeekDay = moment().year(getters.getYear).month(getters.getMonth).week(weeks[index - 1]).day(0);
                    firstWeekDay.add(7, "day");
                    lastWeekDay = moment().year(getters.getYear).month(getters.getMonth).week(weeks[index - 1]).day(6);
                    lastWeekDay.add(6, "day");
                }
                //console.log("From", firstWeekDay.format("YYYY-MM-DD"), weeknumber, "To", lastWeekDay.format("YYYY-MM-DD"), weeknumber);
                weekRange = moment.range(firstWeekDay, lastWeekDay)
                calendar.push(weekRange)
            }
            return calendar
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
    }
}
