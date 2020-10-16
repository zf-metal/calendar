import moment from "moment/moment";

let calculateEnd = function  calculateEnd (start, duration) {
    var end = moment(start)
    end.add(duration, "minutes")
    return end.tz('America/Argentina/Buenos_Aires').format("YYYY-MM-DD HH:mm")
}

export default calculateEnd