import EventProvider from './providers/EventProvider'
import StartProvider from './providers/StartProvider'
import CalendarProvider from './providers/CalendarProvider'
import ServiceProvider from "./providers/ServiceProvider";
import CategoryProvider from "./providers/CategoryProvider";


// Give arg to provider to start endpoint with specific path for example = xxx.com/api/person
export const EventService = new EventProvider('events')
export const StartService = new StartProvider('')
export const CalendarService = new CalendarProvider('calendars')
export const ServiceService = new ServiceProvider('services')
export const CategoryService = new CategoryProvider('category')
