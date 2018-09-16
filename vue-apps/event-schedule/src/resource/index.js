import EventProvider from './providers/EventProvider'
import StartProvider from './providers/StartProvider'
import CalendarProvider from './providers/CalendarProvider'


// Give arg to provider to start endpoint with specific path for example = xxx.com/api/person
export const EventService = new EventProvider('events')
export const StartService = new StartProvider('')
export const CalendarService = new CalendarProvider('calendars')