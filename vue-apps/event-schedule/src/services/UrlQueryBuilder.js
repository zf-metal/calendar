export default class UrlQueryBuilder{

  filters = []
  limit = undefined
  page = undefined
  orderField = undefined

  add(key,operator,value){
    this.filters.push({key:key,operator:operator,value:value})
  }

  setLimit(limit){
  this.limit=limit
  }

  setPage(page){
    this.page = page
  }

  orderBy(field){
    this.orderField = field
  }

  getQuery(){
    let query = "?"
    this.filters.forEach(item => {
      query += item.key + "=" + item.operator + item.value + "&"
    })


    if(this.orderField != undefined){
      query += "orderby=" + this.orderField  + "&"
    }


    if(this.limit != undefined){
      query += "limit=" + this.limit + "&"
    }

    if(this.page != undefined){
      query += "page=" + this.page
    }

    query = query.replace(/&$/, '');

    return query
  }


}
