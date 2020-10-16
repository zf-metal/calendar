
import {calculateEnd} from './../utils/helpers'

export default {
    data: function () {
        return {

        }
    },
    methods: {
        handleDrop: function (data) {
            var event = data.event;
            event.calendar = this.calendarId;
            event.start = this.date + " " + this.hour;
            event.end = calculateEnd(event.start, event.duration);
            event.hour = this.hour;


            if (this.isOutOfRange(event) && !this.isFav(event)) {
                this.alertFavAndHours()
            } else if (this.isOutOfRange(event)) {
                this.alertHours()
            } else if (!this.isFav(event)) {
                this.alertFav()
            }


            if (data.op != undefined && data.op == 'push') {
                this.$store.commit('REMOVE_PRE_EVENTS', this.getPreEventById(event.id));
                this.pushEvent(event);
            }
            if (data.op != undefined && data.op == 'update') {
                this.updateEvent({index: this.getEventIndexById(event.id), event: event});
            }
        },
    }
}