
import HttpRequest from './../HttpRequest'

class ZoneProvider extends HttpRequest {

    findAll(){
        return this.fetchAll()
    }
}

export default ZoneProvider