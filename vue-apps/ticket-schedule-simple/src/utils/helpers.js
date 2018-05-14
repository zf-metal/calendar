function dateToYMD(date) {
  var d = date.getDate();
  var m = date.getMonth() + 1; //Month from 0 to 11
  var y = date.getFullYear();
  return '' + y + '-' + (m<=9 ? '0' + m : m) + '-' + (d <= 9 ? '0' + d : d);
}


function helperMergeStrict(obj1,obj2){
  for (var attr in obj1)
  {
    if(obj2[attr] != undefined) {
      obj1[attr] = obj2[attr];
    }
  }
  return obj1;
}
