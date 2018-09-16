
import HttpRequest from './../HttpRequest'

class CalendarProvider extends HttpRequest {
    createCalendar (calendar) {
        return this.create('', calendar)
    }

    updateCalendar (calendar){
        return this.update(calendar.id, calendar)
    }

    findAll(){
        return this.fetchAll()
    }


}

export default CalendarProvider