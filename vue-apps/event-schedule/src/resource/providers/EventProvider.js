import HttpRequest from './../HttpRequest'
import UrlQueryBuilder from './../../services/UrlQueryBuilder'

class EventProvider extends HttpRequest {
  createEvent(event) {
    return this.create('', event)
  }

  updateEvent(event) {
    return this.update(event.id, event)
  }

  getActiveEvents(date, nextDate, nextEnd) {
    let filters = "?calendar=isNotNull&start=" + date + "<>" + nextDate + " " + nextEnd;
    return this.fetchFilters(filters)
  }

  getPreEvents(date, limit, page) {

    let qb = new UrlQueryBuilder()
    qb.add('calendar', 'isNull', '')
    qb.add('dateFrom', '<=', date)
    qb.orderBy('zone')
    qb.setLimit(limit)
    qb.setPage(page)

    return this.fetchFilters(qb.getQuery())
  }

  getServiceEvents(service, dateFrom, dateTo) {
    let filters = '?service=' + service + '&dateFrom=' + dateFrom + "<>" + dateTo;
    return this.fetchFilters(filters)
  }

  getEventsByServiceYearMonth(service, year, month) {
    return this.axiosInstance.get(
      '/events/search/byServiceYearMonth/' + service + '/' + year + '/' + month
    )
  }

}

export default EventProvider
