import moment from 'moment'
import tz from 'moment-timezone'
import 'moment/locale/es';

const state = {
  loading: 0,
  coordinates: {},
  calendarPosition: {top: 0, left: 0},
  bodyScroll: {top: 0, left: 0},
  calendarScroll: {top: 0, left: 0},
  date: moment().tz('America/Argentina/Buenos_Aires').locale('es'),
  calendars: [],
  vcalendars: [],
  rc: 1,
  preEvents: [],
  events: [],
  eventStates: [],
  eventTypes: [],
  eventSelected: null,
};

export default {state};