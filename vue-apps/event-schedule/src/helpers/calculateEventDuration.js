import moment from "moment/moment";

var calculateEventDuraction = export function calculateEventDuraction(event) {
    if (event.start && event.end) {
        return moment(event.end).diff(moment(event.start), 'minutes');
    }
    return null;
}
export default calculateEventDuraction