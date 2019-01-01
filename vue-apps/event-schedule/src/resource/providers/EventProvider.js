
import HttpRequest from './../HttpRequest'

class EventProvider extends HttpRequest {
    createEvent (event) {
        return this.create('', event)
    }

    updateEvent (event){
        return this.update(event.id, event)
    }

    getActiveEvents(date,nextDate,nextEnd){
        let filters = "?calendar=isNotNull&start=" + date + "<>" + nextDate + " " + nextEnd;
        return this.fetchFilters(filters)
    }

    getPreEvents(date){
        let filters = '?calendar=isNull&state=!=3&dateFrom=<=' + date + '&orderby=zone';
        return this.fetchFilters(filters)
    }

    getServiceEvents(service,dateFrom, dateTo){
        let filters = '?service='+service+'&dateFrom=' + dateFrom + "<>" + dateTo;
        return this.fetchFilters(filters)
    }

    getEventsByServiceYearMonth(service,year, month){
        return this.axiosInstance.get(
            '/events/search/byServiceYearMonth/'+service+'/'+year+'/'+month
        )
    }

}

export default EventProvider