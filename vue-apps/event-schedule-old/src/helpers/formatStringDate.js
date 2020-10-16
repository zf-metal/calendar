import moment from "moment/moment";
var formatStringDate = function formatDate(date,format){
 return moment(date).format(format)
}

export default formatStringDate