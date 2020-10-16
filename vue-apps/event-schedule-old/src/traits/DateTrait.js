import {mapState} from 'vuex';

export default {
    data: function () {
        return {
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
        }
    },
    computed: {
        ...mapState([
            'date',
        ]),
        getDate: function() {
            return this.date.format("YYYY-MM-DD");
        },
        getDay: function() {
            return this.date.isoWeekday();
        },
        getYear: function() {
            return this.date.format('YYYY');
        },
        getMonth: function() {
            return this.date.format('MM');
        },
        getMonthName: function() {
            return this.date.format('MMMM').replace(/\w/, c => c.toUpperCase());
        },
        getDayName: function() {
            return this.date.format('dddd').replace(/\w/, c => c.toUpperCase());
        },
        getNumberOfDayInMonth: function() {
            var cloneDate = this.date.clone().clone();
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
            } while (this.date.month() == cloneDate.month() || flag == false)
            return count;
        },
        getNumberOfDayInMonthOrdinal: function() {
            switch (this.getNumberOfDayInMonth) {
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

    }
}