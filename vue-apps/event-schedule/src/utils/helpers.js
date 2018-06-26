import moment from 'moment'
import tz from 'moment-timezone'
import 'moment/locale/es';

export function calculateEventDuraction(event) {
  if (event.start && event.end) {
    return moment(event.end).diff(moment(event.start), 'minutes');
  }
  return null;
}

export function  calculateEnd (start, duration) {
  var end = moment(start)
  end.add(duration, "minutes")
  return end.tz('America/Argentina/Buenos_Aires').format("YYYY-MM-DD HH:mm")
}


export function calculateDistance(lat1,lon1,lat2,lon2) {
  var R = 6371; // Radius of the earth in km
  var dLat = deg2rad(lat2-lat1);  // deg2rad below
  var dLon = deg2rad(lon2-lon1);
  var a =
    Math.sin(dLat/2) * Math.sin(dLat/2) +
    Math.cos(deg2rad(lat1)) * Math.cos(deg2rad(lat2)) *
    Math.sin(dLon/2) * Math.sin(dLon/2)
  ;
  var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
  var d = R * c; // Distance in km
  return d;
}

function deg2rad(deg) {
  return deg * (Math.PI/180)
}